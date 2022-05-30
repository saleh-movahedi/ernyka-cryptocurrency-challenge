<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Repository\CurrencyRepositoryInterface;
use App\Services\CurrencyService;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepositoryInterface
     */
    private $currencyRepository;
    /**
     * @var CurrencyService
     */
    private $currencyService;

    public function __construct(CurrencyRepositoryInterface $currencyRepository, CurrencyService $currencyService)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->currencyRepository->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurrencyRequest $request)
    {
        $data = $request->validated();
        $this->currencyService->storeCurrency($data);

        return response([
                'message' => 'new currency has been stored successfully'
            ]
            , Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Currency $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->currencyService->showCurrency($id);

        return response(['data' => $data]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCurrencyRequest $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurrencyRequest $request, $id)
    {
        $data = $request->validated();

        $this->currencyService->updateCurrency($id, $data);

        return response([
                'message' => 'new currency has been stored successfully'
            ]
            , Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->currencyService->delete($id);

        return response([
            'message' => 'the specific currency has been deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    public function remoteFetch()
    {
        return $this->currencyService->remoteFetchAllCurrencies();
    }

}
