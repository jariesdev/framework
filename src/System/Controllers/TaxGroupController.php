<?php
namespace AvoRed\Framework\System\Controllers;

use AvoRed\Framework\Database\Contracts\TaxGroupModelInterface;
use AvoRed\Framework\Database\Models\TaxGroup;
use AvoRed\Framework\System\Requests\TaxGroupRequest;

class TaxGroupController
{
    /**
     * TaxGroup Repository for Controller
     * @var \AvoRed\Framework\Database\Repository\TaxGroupRepository $taxGroupRepository
     */
    protected $taxGroupRepository;
    
    /**
     * Construct for the AvoRed tax group controller
     * @param \AvoRed\Framework\Database\Repository\TaxGroupRepository $taxGroupRepository
     */
    public function __construct(
        TaxGroupModelInterface $taxGroupRepository
    ) {
        $this->taxGroupRepository = $taxGroupRepository;
    }

    /**
     * Show Dashboard of an AvoRed Admin
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxGroups = $this->taxGroupRepository->all();

        return view('avored::system.tax-group.index')
            ->with('taxGroups', $taxGroups);
    }

     /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored::system.tax-group.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \AvoRed\Framework\Cms\Requests\TaxGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxGroupRequest $request)
    {
        $this->taxGroupRepository->create($request->all());

        return redirect()->route('admin.tax-group.index')
            ->with('successNotification', __(
                'avored::system.notification.store',
                ['attribute' => __('avored::system.tax-group.title')]
            ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \AvoRed\Framework\Database\Models\TaxGroup $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxGroup $taxGroup)
    {
        return view('avored::system.tax-group.edit')
            ->with('taxGroup', $taxGroup);
    }

    /**
     * Update the specified resource in storage.
     * @param \AvoRed\Framework\Cms\Requests\TaxGroupRequest $request
     * @param \AvoRed\Framework\Database\Models\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function update(TaxGroupRequest $request, TaxGroup $taxGroup)
    {
        $taxGroup->update($request->all());

        return redirect()->route('admin.tax-group.index')
            ->with('successNotification', __(
                'avored::system.notification.updated',
                ['attribute' => __('avored::system.tax-group.title')]
            ));
    }

    /**
     * Remove the specified resource from storage.
     * @param \AvoRed\Framework\Database\Models\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxGroup $taxGroup)
    {
        $taxGroup->delete();

        return [
            'success' => true,
            'message' => __(
                'avored::system.notification.delete',
                ['attribute' => __('avored::system.tax-group.title')]
            )
        ];
    }
}