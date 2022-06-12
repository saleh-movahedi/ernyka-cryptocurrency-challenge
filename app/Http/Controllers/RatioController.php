<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatioRequest;
use App\Models\Ratio;
use App\Repository\RatioRepositoryInterface;

class RatioController extends Controller
{
    /**
     * @var RatioRepositoryInterface
     */
    private $ratioRepository;

    public function __construct(RatioRepositoryInterface $ratioRepository)
    {
        $this->ratioRepository = $ratioRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->ratioRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRatioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRatioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ratio  $ratio
     * @return \Illuminate\Http\Response
     */
    public function show(Ratio $ratio)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ratio  $ratio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ratio $ratio)
    {
        //
    }
}
