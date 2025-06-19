<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use Illuminate\Support\Carbon;

class TenderController extends Controller
{
    /**
     * Создает новый тендер.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'remote_id' => 'required|string',
                'number' => 'required|string',
                'status_id' => 'required|exists:status_dict,id',
                'name' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $tender = Tender::create($validated);

        return response()->json($tender, 201);
    }

    /**
     * Получить тендер по ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $tender = Tender::with('status')->find($id);

        if (empty($tender)) {
            return response()->json(['message' => 'Тендер не найден'], 404);
        }

        return response()->json($tender);
    }

    /**
     * Получает список тендеров с фильтрацией и пагинацией.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Tender::with('status');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->has('date')) {
            $date = Carbon::parse($request->query('date'));
            $query->whereDate('created_at', $date);
        }

        $tenders = $query->paginate(10);

        return response()->json($tenders);
    }
}