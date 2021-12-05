<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AxxerionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $reportNumber = "PS-REP-970";
        $baseUrl = 'https://ps.axxerion.us/webservices/ps/rest/functions/';
        $client = new Client(['base_uri' => $baseUrl]);
        $headers = ['auth' => ['axups', 'ImpAxx!35']];

        $reportCall = $client->request('POST', "completereportresult",
            [
                'headers' => ["Authorization" => "Basic YXh1cHM6SW1wQXh4ITM1"],
                'json' => [
                    'reference' => $reportNumber,
                    "filterFields"=>["objectNameId"],
                    "filterValues"=>["1035"]
                ]
            ]);

        $responseReportBody = json_decode($reportCall->getBody(), true);


       // return( $responseReportBody );

        if (!Schema::hasTable('problemtypes')) {
            // The "users" table exists...

            Schema::create('problemtypes', function (Blueprint $table) use ($headers, $client, $responseReportBody) {
                $objectFields = $responseReportBody['data'];
                $baseUrl3 = 'https://lsl.axxerion.us/services/rest/functions/getvalue/';


              foreach($objectFields as $v)
                {

                   //dd( $v );
                    $fieldName = $v['Name'];
                    $displayType = $v['Display type'];
                    if( !empty( $fieldName )){
                        //echo $fieldName."</br>";
                        $displayType = DB::table('displaytypes')->where('reference', $displayType)->first();
                        if( $displayType == null ){
                           // dd( $v );
                            $fieldType = "string";
                        }
                        else {
                            $fieldType = $displayType->type;
                        }

                       // echo( $fieldType."<br>" );

                        if (!Schema::hasColumn('problemtypes', $fieldName)) {
                            // The "users" table exists and has an "email" column...
                            if( $fieldType == "float"){
                               $table->$fieldType( trim($fieldName), 30, 20 )->nullable();
                            }
                            else {
                                $table->$fieldType( trim($fieldName) )->nullable();
                            }

                        }

                    }

                }

            });
           // dd('table does not exist -->create one');
        }
        else {

            Schema::table('problemtypes', function (Blueprint $table) use ($responseReportBody, $headers, $client) {
                //$table->integer('votes');
                $objectFields = $responseReportBody['data'];

                foreach($objectFields as $v)
                {
                   // dd($v['displayTypeCode']);
                    $fieldName = $v['Name'];
                    $displayType = $v['Display type'];
                    // dd( $responseBody3['value']);
                    if( !empty( $fieldName )){
                        //echo $fieldName."</br>";
                        $displayType = DB::table('displaytypes')->where('reference', $displayType)->first();
                        if( $displayType == null ){
                            // dd( $v );
                            $fieldType = "string";
                        }
                        else {
                            $fieldType = $displayType->type;
                        }

                       // echo( $fieldType."<br>" );
                        if (!Schema::hasColumn('problemtypes', $fieldName)) {
                            // The "users" table exists and has an "email" column...
                            if( $fieldType == "float"){
                                $table->$fieldType( trim($fieldName), 30, 20 )->nullable();
                            }
                            else {
                                $table->$fieldType( trim($fieldName) )->nullable();
                            }
                        }

                    }

                }
            });

        }



        //dd( $responseBody2 );
        return redirect('/home');

       // return Inertia::render('Welcome', ['foo'=> $responseBody2]);
        //return Inertia::render('Welcome', ['foo'=> 'zaaaaa']);


        // return view('home');
    }

    public function indexOld()
    {

        $reportNumber = "PS-REP-970";
        $baseUrl = 'https://lsl.axxerion.us/services/rest/functions/findbyfield/';
        $client = new Client(['base_uri' => $baseUrl]);
        $headers = ['auth' => ['axulsl', 'Srm89']];
        $response = $client->request('GET', "ObjectName/name/ProblemType", $headers);
        $responseBody = json_decode($response->getBody(), true);
        $objectNameId = $responseBody['objects'][0]['id'];
        //$client2 = new Client(['base_uri' => 'https://lsl.axxerion.us/services/rest/functions/findbyfield/ObjectField/objectNameId/'.$objectNameId ]);
        //$headers2 = ['auth' => ['axulsl', 'Srm89']];
        $response2 = $client->request('GET', "ObjectField/objectNameId/".$objectNameId, $headers);
        $responseBody2 = json_decode($response2->getBody(), true);

        $reportCall = $client->request('POST', "https://lsl.axxerion.us/webservices/lsl/rest/functions/reportresult",
            [
                'headers' => $headers,
                'body' => json_encode([
                    'reference' => $reportNumber,
                ])
            ]);
        $responseReportBody = json_decode($reportCall->getBody(), true);


        return( $responseReportBody );

        if (!Schema::hasTable('problemtypes')) {
            // The "users" table exists...

            Schema::create('problemtypes', function (Blueprint $table) use ($headers, $client, $responseBody2) {
                $objectFields = $responseBody2['objects'];
                $baseUrl3 = 'https://lsl.axxerion.us/services/rest/functions/getvalue/';

                foreach($objectFields as $i => $v)
                {
                    //dd($v['fieldNameId']);
                    $response3 = $client->request('GET', $baseUrl3.'FieldName/name/'.$v['fieldNameId'], $headers);
                    $responseBody3 = json_decode($response3->getBody(), true);
                    // dd( $responseBody3['value']);
                    $fieldName = $responseBody3['value'];
                    if( !empty( $fieldName )){
                        //echo $fieldName."</br>";
                        $displayType = DB::table('displaytypes')->where('reference', $v['displayTypeCode'])->first();
                        if( $displayType == null ){
                            // dd( $v );
                            $fieldType = "string";
                        }
                        else {
                            $fieldType = $displayType->type;
                        }

                        // echo( $fieldType."<br>" );

                        if (!Schema::hasColumn('problemtypes', $fieldName)) {
                            // The "users" table exists and has an "email" column...
                            $table->$fieldType( trim($fieldName) );

                        }

                    }

                }

            });
            // dd('table does not exist -->create one');
        }
        else {

            Schema::table('problemtypes', function (Blueprint $table) use ($responseBody2, $headers, $client) {
                //$table->integer('votes');
                $objectFields = $responseBody2['objects'];
                $baseUrl3 = 'https://lsl.axxerion.us/services/rest/functions/getvalue/';

                foreach($objectFields as $i => $v)
                {
                    // dd($v['displayTypeCode']);
                    $displayType = DB::table('displaytypes')->where('reference', $v['displayTypeCode'])->first();

                    $response3 = $client->request('GET', $baseUrl3.'FieldName/name/'.$v['fieldNameId'], $headers);
                    $responseBody3 = json_decode($response3->getBody(), true);
                    // dd( $responseBody3['value']);
                    $fieldName = $responseBody3['value'];
                    if( !empty( $fieldName )){
                        //echo $fieldName."</br>";
                        $displayType = DB::table('displaytypes')->where('reference', $v['displayTypeCode'])->first();
                        if( $displayType == null ){
                            // dd( $v );
                            $fieldType = "string";
                        }
                        else {
                            $fieldType = $displayType->type;
                        }

                        // echo( $fieldType."<br>" );
                        if (!Schema::hasColumn('problemtypes', $fieldName)) {
                            // The "users" table exists and has an "email" column...
                            $table->$fieldType( trim($fieldName) );

                        }

                    }

                }
            });

        }



        //dd( $responseBody2 );
        return redirect('/home');

        // return Inertia::render('Welcome', ['foo'=> $responseBody2]);
        //return Inertia::render('Welcome', ['foo'=> 'zaaaaa']);


        // return view('home');
    }
}
