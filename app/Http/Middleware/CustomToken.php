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
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $bearerToken = $request->bearerToken() ?? '';
        if($bearerToken === '' && $this->openClosedBrackets($bearerToken)){
            return $next($request);
        }

        return response()->json(['error' => 'Invalid Bearer Token request'], 403);
    }

    /**
     * Find and remove matched brackets
     * 
     * @param string $str
     * @return boolean
     */
    private function openClosedBrackets($str): boolean
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
     * @param string $brackets
     * @param string $string
     * @return int|boolean
     */
    private function findBrackets($brackets, $string): int|boolean
    {
        return strpos($string, $brackets) !== false;
    }
    
    /**
     * Replace and remove matched brackets
     * 
     * @param string $brackets
     * @param string $string
     * @return string
     */
    private function replaceMatch($brackets, $string): string
    {
        return str_replace($brackets, "", $string);
    }
}
