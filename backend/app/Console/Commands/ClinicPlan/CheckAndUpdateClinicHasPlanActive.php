<?php

namespace App\Console\Commands\ClinicPlan;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAndUpdateClinicHasPlanActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-and-update-clinic-has-plan-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check or validate date the clinic has plan active and update the column active in clinic_has_plans';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activePlans = $this->getActivePlans();

        // loop through the active plans
        foreach ($activePlans as $activePlan) {

            $to = Carbon::parse($activePlan->to);

            if (Carbon::now()->greaterThan($to)) {
                // update the column active to false
                $clinicHasPlanRepository = app()->make(\App\Interfaces\Repositories\ClinicHasPlanRepositoryInterface::class);
                $clinicHasPlanRepository->update(['active' => false], $activePlan->id);
            }
        }

        $this->info('Check or validate date the clinic has plan active and update the column active in clinic_has_plans');

        return 0;
    }

    /**
     * Get active plans
     */
    private function getActivePlans()
    {
        $clinicHasPlanRepository = app()->make(\App\Interfaces\Repositories\ClinicHasPlanRepositoryInterface::class);
        return $clinicHasPlanRepository->getActivePlans();
    }
}
