<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictController extends Controller
{
    public function index()
    {
        $title = 'Cunny | Img Classify';
        return view('predict.index', compact('title'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        try {

            $response = Http::timeout(60)
                ->attach(
                    'uploaded_file',
                    file_get_contents(
                        $request->file('image')->getRealPath()
                    ),
                    $request->file('image')->getClientOriginalName()
                )
                ->post(env('API_URL'));

            if (!$response->successful()) {

                return back()->withErrors([
                    'api' => 'Prediction API unavailable.'
                ]);
            }

            session([
                'prediction' => $response->json()
            ]);

            return redirect()->route('img-classify.result');

        } catch (\Exception $e) {

            return back()->withErrors([
                'api' => $e->getMessage()
            ]);
        }
    }

    public function result()
    {
        $prediction = session('prediction');
        $title = 'Cunny | Predict Result';
        if (!$prediction) {
            return redirect()->route('img-classify.index');
        }

        return view(
            'predict.predict-result',
            compact('prediction', 'title')
        );
    }
}
