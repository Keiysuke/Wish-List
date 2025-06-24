<?php

namespace App\Services;

use App\Models\Crowdfunding;
use Illuminate\Http\Request;

class CrowdfundingService
{
    public function createFromRequest(Request $request): Crowdfunding
    {
        if ($this->exists($request->project_name, $request->website_id)) {
            throw new \Exception(__('Ce projet participatif existe déjà pour ce site.'));
        }
        return Crowdfunding::create($request->all());
    }
    
    public function exists(string $projectName, $websiteId): bool
    {
        return \App\Models\Crowdfunding::where('project_name', $projectName)
            ->where('website_id', $websiteId)
            ->exists();
    }
}
