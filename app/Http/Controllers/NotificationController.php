<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Notification::all();
        if(!$alerts->count()) {
            return response()->json(['code' => 400, 'message' => 'No tokens found.', 'status' => 'error'], 400);
        }
        /*
        curl -H "Content-Type: application/json" -X POST "https://exp.host/--/api/v2/push/send" -d '{
          "to": "ExponentPushToken[EZOVI7JGpy0ILZl-eQiXnM]",
          "title":"hello",
          "body": "world"
        }'
        */
        $ch = \curl_init();

        $data = array(
            'to'    => 'ExponentPushToken[EZOVI7JGpy0ILZl-eQiXnM]',
            'title' => 'Foo',
            'body'  => 'bar'
        );

        \curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        \curl_setopt($ch, CURLOPT_URL,"https://exp.host/--/api/v2/push/send");
        \curl_setopt($ch, CURLOPT_POST, 1);
        \curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Receive server response ...
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        \curl_close($ch);

        return response()->json(['code' => 200, 'tokens' => $alerts, 'status' => 'success'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Notification::create([
            'expo_token' => $request->expo_token
        ]);

        return response()->json(['code' => 200, 'message' => 'Token successfully stored!', 'status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
