<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken() ?? '';
        if($bearerToken === '' || $this->openClosedBrackets($bearerToken)){
            return $next($request);
        }

        return response()->json(['error' => 'Invalid Bearer Token request'], 403);
    }

    /**
     * Find and remove matched brackets
     */
    private function openClosedBrackets(string $str): bool
    {
        // Remove unneeded chars
        $str = preg_replace('/[^\{\}\(\)\[\]]+/', '', $str);
        while(true){
            if($this->findBrackets('{}', $str)) {
                $str = $this->replaceMatch('{}', $str);
            } elseif($this->findBrackets('[]', $str)) {
                $str = $this->replaceMatch('[]', $str);
            } elseif($this->findBrackets('()', $str)) {
                $str = $this->replaceMatch('()', $str);
            } else {
                // If any of sets are not found, exit the loop
                break;
            }
        }

        return !strlen($str);
    }

    /**
     * Find matched brackets
     * 
     * @return int|bool
     */
    private function findBrackets(string $brackets, string $string)
    {
        return strpos($string, $brackets) !== false;
    }
    
    /**
     * Replace and remove matched brackets
     */
    private function replaceMatch(string $brackets, string $string): string
    {
        return str_replace($brackets, "", $string);
    }
}