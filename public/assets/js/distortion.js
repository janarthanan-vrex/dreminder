
class GridDistortion {
  constructor(selector, options = {}) {
    // Container
    this.container = typeof selector === 'string'
      ? document.querySelector(selector)
      : selector;

    if (!this.container) {
      console.error('GridDistortion: container not found');
      return;
    }

    // Options with defaults
    this.options = {
      imageSrc: options.imageSrc || 'https://picsum.photos/1920/1080?grayscale',
      grid: options.grid || 15,
      mouse: options.mouse || 0.1,
      strength: options.strength || 0.15,
      relaxation: options.relaxation || 0.9,
    };

    // State
    this.imageAspect = 1;
    this.animationId = null;
    this.resizeObserver = null;
    this.isDestroyed = false;

    this.mouseState = {
      x: 0,
      y: 0,
      prevX: 0,
      prevY: 0,
      vX: 0,
      vY: 0
    };

    // Bound handlers (for cleanup)
    this._onMouseMove = this._handleMouseMove.bind(this);
    this._onMouseLeave = this._handleMouseLeave.bind(this);
    this._onTouchMove = this._handleTouchMove.bind(this);
    this._onTouchEnd = this._handleMouseLeave.bind(this);
    this._onResize = this._handleResize.bind(this);

    this._init();
  }

  // ---- SHADERS ----
  static get vertexShader() {
    return `
      uniform float time;
      varying vec2 vUv;
      varying vec3 vPosition;

      void main() {
        vUv = uv;
        vPosition = position;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }
    `;
  }

  static get fragmentShader() {
    return `
      uniform sampler2D uDataTexture;
      uniform sampler2D uTexture;
      uniform vec4 resolution;
      varying vec2 vUv;

      void main() {
        vec2 uv = vUv;
        vec4 offset = texture2D(uDataTexture, vUv);
        gl_FragColor = texture2D(uTexture, uv - 0.02 * offset.rg);
      }
    `;
  }

  // ---- INITIALIZATION ----
  _init() {
    const { container, options } = this;

    // Ensure container styling
    container.style.overflow = 'hidden';
    container.style.position = container.style.position || 'relative';
    container.style.minWidth = '0';
    container.style.minHeight = '0';

    // Scene
    this.scene = new THREE.Scene();

    // Renderer
    this.renderer = new THREE.WebGLRenderer({
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance'
    });
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.renderer.setClearColor(0x000000, 0);

    // Style canvas to fill container
    const canvas = this.renderer.domElement;
    canvas.style.display = 'block';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.position = 'absolute';
    canvas.style.top = '0';
    canvas.style.left = '0';

    container.appendChild(canvas);

    // Camera (orthographic)
    this.camera = new THREE.OrthographicCamera(0, 0, 0, 0, -1000, 1000);
    this.camera.position.z = 2;

    // Uniforms
    this.uniforms = {
      time: { value: 0 },
      resolution: { value: new THREE.Vector4() },
      uTexture: { value: null },
      uDataTexture: { value: null }
    };

    // Data texture (distortion grid)
    this._createDataTexture();

    // Material
    this.material = new THREE.ShaderMaterial({
      side: THREE.DoubleSide,
      uniforms: this.uniforms,
      vertexShader: GridDistortion.vertexShader,
      fragmentShader: GridDistortion.fragmentShader,
      transparent: true
    });

    // Geometry & Mesh
    this.geometry = new THREE.PlaneGeometry(1, 1, options.grid - 1, options.grid - 1);
    this.plane = new THREE.Mesh(this.geometry, this.material);
    this.scene.add(this.plane);

    // Load image
    this._loadImage(options.imageSrc);

    // Events
    this._bindEvents();

    // Initial size
    this._handleResize();

    // Start animation
    this._animate();
  }

  // ---- DATA TEXTURE ----
  _createDataTexture() {
    const size = this.options.grid;
    this.dataArray = new Float32Array(4 * size * size);

    for (let i = 0; i < size * size; i++) {
      this.dataArray[i * 4] = Math.random() * 255 - 125;
      this.dataArray[i * 4 + 1] = Math.random() * 255 - 125;
      this.dataArray[i * 4 + 2] = 0;
      this.dataArray[i * 4 + 3] = 1;
    }

    this.dataTexture = new THREE.DataTexture(
      this.dataArray,
      size,
      size,
      THREE.RGBAFormat,
      THREE.FloatType
    );
    this.dataTexture.needsUpdate = true;
    this.uniforms.uDataTexture.value = this.dataTexture;
  }

  // ---- IMAGE LOADING ----
  _loadImage(src) {
    const loader = new THREE.TextureLoader();

    loader.load(
      src,
      (texture) => {
        if (this.isDestroyed) return;

        texture.minFilter = THREE.LinearFilter;
        texture.magFilter = THREE.LinearFilter;
        texture.wrapS = THREE.ClampToEdgeWrapping;
        texture.wrapT = THREE.ClampToEdgeWrapping;

        this.imageAspect = texture.image.width / texture.image.height;

        // Dispose old texture if exists
        if (this.uniforms.uTexture.value) {
          this.uniforms.uTexture.value.dispose();
        }

        this.uniforms.uTexture.value = texture;
        this._handleResize();
      },
      undefined,
      (err) => {
        console.error('GridDistortion: failed to load image', err);
      }
    );
  }

  // ---- EVENT BINDING ----
  _bindEvents() {
    const { container } = this;

    // Mouse
    container.addEventListener('mousemove', this._onMouseMove);
    container.addEventListener('mouseleave', this._onMouseLeave);

    // Touch
    container.addEventListener('touchmove', this._onTouchMove, { passive: true });
    container.addEventListener('touchend', this._onTouchEnd);

    // Resize
    if (window.ResizeObserver) {
      this.resizeObserver = new ResizeObserver(() => this._handleResize());
      this.resizeObserver.observe(container);
    } else {
      window.addEventListener('resize', this._onResize);
    }
  }

  // ---- EVENT HANDLERS ----
  _handleMouseMove(e) {
    const rect = this.container.getBoundingClientRect();
    const x = (e.clientX - rect.left) / rect.width;
    const y = 1 - (e.clientY - rect.top) / rect.height;

    this.mouseState.vX = x - this.mouseState.prevX;
    this.mouseState.vY = y - this.mouseState.prevY;
    this.mouseState.x = x;
    this.mouseState.y = y;
    this.mouseState.prevX = x;
    this.mouseState.prevY = y;
  }

  _handleTouchMove(e) {
    if (!e.touches[0]) return;
    const rect = this.container.getBoundingClientRect();
    const x = (e.touches[0].clientX - rect.left) / rect.width;
    const y = 1 - (e.touches[0].clientY - rect.top) / rect.height;

    this.mouseState.vX = x - this.mouseState.prevX;
    this.mouseState.vY = y - this.mouseState.prevY;
    this.mouseState.x = x;
    this.mouseState.y = y;
    this.mouseState.prevX = x;
    this.mouseState.prevY = y;
  }

  _handleMouseLeave() {
    if (this.dataTexture) {
      this.dataTexture.needsUpdate = true;
    }
    this.mouseState.x = 0;
    this.mouseState.y = 0;
    this.mouseState.prevX = 0;
    this.mouseState.prevY = 0;
    this.mouseState.vX = 0;
    this.mouseState.vY = 0;
  }

  _handleResize() {
    if (this.isDestroyed || !this.container || !this.renderer || !this.camera) return;

    const rect = this.container.getBoundingClientRect();
    const width = rect.width;
    const height = rect.height;

    if (width === 0 || height === 0) return;

    const containerAspect = width / height;

    this.renderer.setSize(width, height);

    if (this.plane) {
      this.plane.scale.set(containerAspect, 1, 1);
    }

    const frustumHeight = 1;
    const frustumWidth = frustumHeight * containerAspect;
    this.camera.left = -frustumWidth / 2;
    this.camera.right = frustumWidth / 2;
    this.camera.top = frustumHeight / 2;
    this.camera.bottom = -frustumHeight / 2;
    this.camera.updateProjectionMatrix();

    this.uniforms.resolution.value.set(width, height, 1, 1);
  }

  // ---- ANIMATION LOOP ----
  _animate() {
    if (this.isDestroyed) return;

    this.animationId = requestAnimationFrame(() => this._animate());

    if (!this.renderer || !this.scene || !this.camera) return;

    const { grid, mouse, strength, relaxation } = this.options;
    const size = grid;

    this.uniforms.time.value += 0.05;

    // Relax distortion
    const data = this.dataArray;
    for (let i = 0; i < size * size; i++) {
      data[i * 4] *= relaxation;
      data[i * 4 + 1] *= relaxation;
    }

    // Apply mouse influence
    const gridMouseX = size * this.mouseState.x;
    const gridMouseY = size * this.mouseState.y;
    const maxDist = size * mouse;
    const maxDistSq = maxDist * maxDist;

    for (let i = 0; i < size; i++) {
      for (let j = 0; j < size; j++) {
        const dx = gridMouseX - i;
        const dy = gridMouseY - j;
        const distSq = dx * dx + dy * dy;

        if (distSq < maxDistSq) {
          const index = 4 * (i + size * j);
          const power = Math.min(maxDist / Math.sqrt(distSq), 10);
          data[index] += strength * 100 * this.mouseState.vX * power;
          data[index + 1] -= strength * 100 * this.mouseState.vY * power;
        }
      }
    }

    this.dataTexture.needsUpdate = true;
    this.renderer.render(this.scene, this.camera);
  }

  // ---- PUBLIC METHODS ----

  /** Swap the image */
  updateImage(src) {
    this._loadImage(src);
  }

  /** Update options on the fly */
  updateOptions(opts) {
    const needsRebuild = opts.grid && opts.grid !== this.options.grid;

    Object.assign(this.options, opts);

    if (needsRebuild) {
      // Rebuild data texture and geometry for new grid size
      if (this.dataTexture) this.dataTexture.dispose();
      this._createDataTexture();

      if (this.geometry) this.geometry.dispose();
      this.geometry = new THREE.PlaneGeometry(1, 1, this.options.grid - 1, this.options.grid - 1);
      this.plane.geometry = this.geometry;

      this._handleResize();
    }
  }

  /** Clean up everything */
  destroy() {
    this.isDestroyed = true;

    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
      this.animationId = null;
    }

    // Events
    this.container.removeEventListener('mousemove', this._onMouseMove);
    this.container.removeEventListener('mouseleave', this._onMouseLeave);
    this.container.removeEventListener('touchmove', this._onTouchMove);
    this.container.removeEventListener('touchend', this._onTouchEnd);

    if (this.resizeObserver) {
      this.resizeObserver.disconnect();
      this.resizeObserver = null;
    } else {
      window.removeEventListener('resize', this._onResize);
    }

    // Three.js cleanup
    if (this.geometry) this.geometry.dispose();
    if (this.material) this.material.dispose();
    if (this.dataTexture) this.dataTexture.dispose();
    if (this.uniforms.uTexture.value) this.uniforms.uTexture.value.dispose();

    if (this.renderer) {
      this.renderer.dispose();
      if (this.container.contains(this.renderer.domElement)) {
        this.container.removeChild(this.renderer.domElement);
      }
    }

    this.scene = null;
    this.renderer = null;
    this.camera = null;
    this.plane = null;
  }
}

/* ================================================================
   INITIALIZE
   ================================================================ */
document.addEventListener('DOMContentLoaded', () => {

  // Basic usage
  const distortion = new GridDistortion('#grid-distortion-container', {
    imageSrc: 'https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIzLTA4L3Jhd3BpeGVsb2ZmaWNlMjBfM2RfbW9kZXJuX3dhdmVfY3VydmVfYWJzdHJhY3RfaGFsZnRvbmVfZ3JhZGllbl8xZTJhY2M3Mi1jZTU3LTQ0NjItOGQzNS1lOTI4YzI5NzcxMTdfMS5qcGc.jpg',
    grid: 10,
    mouse: 0.1,
    strength: 1,
    relaxation: 0.9
  });

  // --- OPTIONAL: Dynamic controls ---

  // Swap image at any time:
  // distortion.updateImage('https://picsum.photos/1920/1080');

  // Change settings live:
  // distortion.updateOptions({ strength: 0.3, mouse: 0.2 });

  // Change grid size (rebuilds geometry):
  // distortion.updateOptions({ grid: 20 });

  // Cleanup when done:
  // distortion.destroy();

});