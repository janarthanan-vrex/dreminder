git status           $reminder->save();
            return;
        }

        $monthsMap = [
            'monthly'     => 1,
            'quarterly'   => 3,
            'half-yearly' => 6,
            'annually'    => 12,
        ];

        $months = $monthsMap[strtolower($reminder->payment_frequency)] ?? 0;

        if ($months === 0) {
            return;
        }

        $currentDate = Carbon::parse($reminder->reminder_date);
        $originalDay = $currentDate->day;
        $next        = $currentDate->copy()->addMonths($months);
        $nextDate    = $next->day(min($originalDay, $next->daysInMonth));

        if (
            $reminder->end_reminder_date &&
            $reminder->end_reminder_date != '0000-00-00'
        ) {
            $endDate = Carbon::parse($reminder->end_reminder_date);

            if ($nextDate->gt($endDate)) {
                $reminder->reminder_status = 'completed';
                $reminder->save();
                return;
            }
        }

        $reminder->reminder_date = $nextDate->format('Y-m-d');
        $reminder->save();
    }
}