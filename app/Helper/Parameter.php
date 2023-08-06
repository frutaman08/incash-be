<?php

namespace App\Helper;

use Illuminate\Http\Request;

trait Parameter
{
  public function setParameterQuery(Request $request, $customKey = [])
  {
    $parameters = [
      'search' => $request->input('search', ''),
      'perPage' => $request->input('perPage', '10') > 100 ? 100 : $request->input('perPage', '10'),
      'orderBy' => $request->input('orderBy', 'created_at'),
      'orderDirection' => $request->input('orderDirection', 'desc'),
    ];

    foreach ($customKey as $key => $value) {
      $parameters[$key] = $request->input($value, null);
    }

    return $parameters;
  }
}
