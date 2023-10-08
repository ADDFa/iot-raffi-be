<?php

namespace App\Http\Controllers;

use App\Http\Helper\Response;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $result = [];
        if ($request->user->role === "doctor") {
            $result = Result::with("user")->get();
        } else {
            $result = Result::where("user_id", $request->user->id)->with("user")->get();
        }

        return Response::success($result);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id"           => "required|exists:users,id",
            "adc"               => "required|numeric",
            "glucose"           => "required|numeric",
            "clasification"     => [
                "required",
                Rule::in(["Diabetes", "Normal"])
            ]
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $result = new Result([
            "user_id"           => $request->user_id,
            "adc"               => $request->adc,
            "glucose"           => $request->glucose,
            "clasification"     => $request->clasification
        ]);
        $result->save();

        return Response::message("Hasil berhasil ditambahkan!", 200);
    }
}
