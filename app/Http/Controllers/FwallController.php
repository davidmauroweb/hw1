<?php

namespace App\Http\Controllers;

use App\Models\fwall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FwallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fwall  $fwall
     * @return \Illuminate\Http\Response
     */
    public function show($fwall)
    {
	$encoded = base64_encode('adm1nya' . ':' . 'eWV2kAMkNmnu9r8SUXIg');
	$authHeader = ['Authorization: Basic ' . $encoded];
        //
	$u0="https://adguard-sn.pcassi.net/control/filtering/status";
	$u1="https://adguard-sn.pcassi.net/control/querylog?search=";
	$u1b='&response_status="blocked"';
	$u1bs='&response_status="blocked_safebrowsing"';
	$u1bp='&response_status="blocked_parental"';

	$ub = $u1.$fwall.$u1b;
	$ubs = $u1.$fwall.$u1bs;
	$ubp = $u1.$fwall.$u1bp;

	echo $u0."<br>";

	$ch0 = curl_init();
	curl_setopt($ch0, CURLOPT_URL, $u0 );
	curl_setopt($ch0, CURLOPT_HTTPHEADER, $authHeader);
	curl_setopt($ch0, CURLOPT_RETURNTRANSFER, true);
	$reg0 = curl_exec($ch0)."<br>";
//	$reg0_response = json_decode($reg0);
	echo $reg0."<br><br>";

//
	echo $ub."<br>";

	$chb = curl_init();
	curl_setopt($chb, CURLOPT_URL, $ub );
	curl_setopt($chb, CURLOPT_HTTPHEADER, $authHeader);
	curl_setopt($chb, CURLOPT_RETURNTRANSFER, true);
	$regb = curl_exec($chb);
//	$regb_response = json_decode($regb);
	echo $regb."<br><br>";

	echo $ubs."<br>";
	$chbs = curl_init();
	curl_setopt($chbs, CURLOPT_URL, $ubs );
	curl_setopt($chbs, CURLOPT_HTTPHEADER, $authHeader);
	curl_setopt($chbs, CURLOPT_RETURNTRANSFER, true);
	$regbs = curl_exec($chbs);
//	$regbs_response = json_decode($regbs);
        echo $regbs."<br><br>";

	echo $ubp."<br>";
	$chbp = curl_init();
	curl_setopt($chbp, CURLOPT_URL, $ubp );
	curl_setopt($chbp, CURLOPT_HTTPHEADER, $authHeader);
	curl_setopt($chbp, CURLOPT_RETURNTRANSFER, true);
	$regbp = curl_exec($chbp);
//	$regbp_response = json_decode($regbp);
        echo $regbp."<br><br>";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\fwall  $fwall
     * @return \Illuminate\Http\Response
     */
    public function edit(fwall $fwall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\fwall  $fwall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fwall $fwall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fwall  $fwall
     * @return \Illuminate\Http\Response
     */
    public function destroy(fwall $fwall)
    {
        //
    }
}
