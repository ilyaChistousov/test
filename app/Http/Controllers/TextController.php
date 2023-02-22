<?php

namespace App\Http\Controllers;
use App\Models\Text;
use DOMDocument;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function check(Request $request) {
        $content = $request->input('text');
        $untaggedText = strip_tags($content);

        //все схожие буквы во всевозможных комбинациях, написанные как на русском, так и на английском языках
        $sameChars = [
            'a', 'A', 'а', 'А',
            'c', 'C', 'с', 'С',
            'e', 'E', 'е', 'Е',
            'o', 'O', 'о', 'О',
            'p', 'P', 'р', 'Р',
            'x', 'X', 'х', 'Х',
            'y', 'у', 'H', 'K',
            'T', 'B', 'M'
        ];

        $countEng = preg_match_all('/[a-z]/iu', $untaggedText);
        $countRus = preg_match_all('/[а-я]/iu', $untaggedText);

        $result = $countEng > $countRus ?
            $this->replaceChar('/[а-я]/iu', $untaggedText, $sameChars) :
            $this->replaceChar('/[a-z]/iu', $untaggedText, $sameChars);

        Text::create(['content' => $result]);
        return response()->json($result);
    }

    private function replaceChar(string $pattern, string $text, array $charsArray) {
        return preg_replace_callback($pattern, function ($matches) use ($charsArray){
            if (in_array($matches[0], $charsArray)) {
                return "<strong>$matches[0]</strong>";
            }
            return $matches[0];
        }, $text);
    }
}
