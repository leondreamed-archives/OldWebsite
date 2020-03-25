<div class="text-content">
  <div id="waiting">
    <div id = "progress-bar">
        <div id = "progress">
        </div>
    </div>
    Loading...
  </div>
  <div id = "finished" style="display: none">
    <a id='downloadLink'>Download</a><br />
    <div id = "result"></div>
  </div>
</div>
<script>
"use strict";

var textFile;

// Puts the translation into a text file
function makeTextFile(text) {
    var textFile = null;
    text = text.trim().replace(/<br\s*\/?>/g, '\n');
    var data = new Blob([text], {type: 'text/plain'});

    if (textFile !== null) {
      window.URL.revokeObjectURL(textFile);
    }

    textFile = window.URL.createObjectURL(data);
    
    
    
    return textFile;
};

// Making sure all data entered is safe
<?php foreach($_POST as &$term) {
    // Preventing XSS from string interpolation in JS from ${...}
    $term = htmlspecialchars($term);
    $term = preg_replace_callback('~\\\\~', function() {
        return '&#92;';
    }, $term);
    $term = preg_replace_callback('~\$\{~', function() {
        return '$\{';
    }, $term);
    // Preventing XSS from sneaky backticks
    $term = preg_replace_callback('~`~', function() {
        return '&#96;';
    }, $term);
    // Preventing XSS from sneaky backslashes
} ?>

var logObj = <?php echo isset($_POST["logObj"]) ? 'true' : 'false' ?>

// All the translation data is here
var translations = {};

// Word Separator (input)
var sep = <?php
    echo (!isset($_POST["sep"]) || $_POST["sep"] == '') ? '"\n"' : '`'.$_POST["sep"].'`';
?>;

// Grouping defintions together or not
var group = <?php echo isset($_POST["group"]) ? 'true' : 'false'; ?>;

// Printing separator (output)
var printSep = <?php
    echo (!isset($_POST["printsep"]) || $_POST["printsep"] == '') ? '" | "' : '`'. $_POST["printsep"].'`';
?>;

// Show examples or not
var showExamples = <?php echo isset($_POST["examples"]) ? 'true' : 'false'; ?>;

var showPhrases = <?php echo isset($_POST["examples"]) ? 'true' : 'false'; ?>;

var showUseOnBothSides = <?php echo isset($_POST["showUseOnBothSides"]) ? 'true' : 'false'; ?>;

var showPOSOnBothSides = <?php echo isset($_POST["showPOSOnBothSides"]) ? 'true' : 'false'; ?>;

var showLanguageLabel = <?php echo isset($_POST["showLanguageLabel"]) ? 'true' : 'false'; ?>;

// Getting the translation page's raw content
var pages = String.raw`
<?php
    ini_set('max_execution_time', 0);

    if ($_POST["toOrFrom"] == "from") {
        $fromLang = "english";
        $GLOBALS["toLang"] = $_POST["language"];
    }
    else {
        $fromLang = $_POST["language"];
        $GLOBALS["toLang"] = "english";
    }
    
    $recurse = isset($_POST["recurse"]);
    $newWords = array();
    // The language to start from to the language to end at

    $preURL = "https://www.collinsdictionary.com/dictionary/$fromLang-$toLang/";
    // This function checks if the URL redirects
    function urlRedirectionCheck($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);
        $out = curl_exec($ch);

        $out = str_replace("\r", "", $out);

        $headers_end = strpos($out, "\n\n");
        if ($headers_end !== false)
            $out = substr($out, 0, $headers_end);

        $headers = explode("\n", $out);
        foreach($headers as $header) {
            if(substr($header, 0, 10) == "Location: " ) {
                $target = substr($header, 10);
                return $target;
            }
        }
        return $url;
    }
    
    function removeAccents(string $URL) {
        $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a','á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        return strtr($URL, $unwanted_array);
    }
    
    function getWord(string $URL) {
        if (preg_match('~/spellcheck/.*\?q.*$~', $URL)) {
            return false;
        } else {
            global $preURL;
            $newWord = array();
            // Getting the word the URL redirected to
            preg_match('~'.$preURL.'(.*?)(?:_\d+)?$~', $URL, $newWord);
            $newWord = isset($newWord[1]) ? urldecode($newWord[1]) : "";
            if ($newWord == '')
                return false;
            else
                return $newWord;
        }
    }
    
    function getContents(string $URL, array &$words) {
        global $newWords;
        if (($word = getWord($URL)) === false) {
            return false;
        } else {
            array_push($newWords, $word);
        }
        // Extracting the useful parts of the domain content
        $domain = file_get_contents($URL);
        $origDomain = $domain;
        $origPos = 0;
        while (($origPos = $lastStartPos = stripos($origDomain, '<div class="hom">', $origPos + 1)) !== false) {
            $lastEndPos = $lastStartPos;
            do {
                $lastEndPos = stripos($origDomain, '</div', $lastEndPos + 1);
                $lastStartPos = stripos($origDomain, '<div', $lastStartPos + 1);
            } while ($lastStartPos < $lastEndPos);
            
            $domain = substr($origDomain, $origPos, $lastEndPos + 6 - $origPos);
            
            // Replacing all script tags with a temporary different tag (to avoid early script break)
            $domain = preg_replace_callback('~</script>~', function() {
                return '<endscript>';
            }, $domain);
            // Escaping all tilde characters (to avoid early string break)
            $domain = preg_replace_callback('~`~', function() {
                return '\`';
            }, $domain);
            
            echo $domain;
        }
        
        global $recurse;
        if ($recurse) {
            // Finding recursive translations
            $lastXR = $lastEndPos;
            while (($lastXR = stripos($origDomain, '<span class="xr">', $lastXR + 1)) !== false) {
                $aStart = stripos($origDomain, '<a href=', $lastXR);
                $aEnd = stripos($origDomain, '</a>', $aStart);
                $aStr = substr($origDomain, $aStart, $aEnd - $aStart);
                
               
                $extractedURL = array();
                
                if (preg_match('~href="([^"]+)"~', $aStr, $extractedURL)) {
                    $extractedURL = isset($extractedURL[1]) ? $extractedURL[1] : "";

                    if (array_search(getWord($extractedURL), $newWords) === false) {
                        echo '<pagebreak>';
                        getContents($extractedURL, $words);
                    }
                }
            }
        }
        return true;
    }
    
    // List of invalid words whose translation page could not be found
    $_SERVER["INVALID_WORDS"] = array();
    
    // Word Separator (input)
    $regSep = '';
    $sep = ($_POST["sep"] == "") ? PHP_EOL : $_POST["sep"];
    if ($sep != PHP_EOL)
        $regSep .= '\n';
    if (stripos($sep, '\r') === false)
        $regSep .= '\r';
    
    // Replacing all tab and newline characters with a space
    $_POST["wordsToTranslate"] = preg_replace_callback("~[{$regSep}]+~", function() {
        return ' ';
    }, $_POST["wordsToTranslate"]);
    
    // Splitting all the words into an array of these words
    $words = explode($sep, $_POST["wordsToTranslate"]);

    foreach ($words as $key => $word)
        $words[$key] = trim($word);
    $words = array_unique($words);
    
    foreach ($words as $word) {

        // Replacing spaces with '-' in URL
        $word = preg_replace_callback('~\s~', function() {
            return '-';
        }, $word);
        
        // Prefix for URL
        $URL = urlRedirectionCheck($preURL . strtolower(urlencode($word)));
        
        if (getContents($URL, $words) === false) {
            array_push($_SERVER["INVALID_WORDS"], $word);
            continue;
        } else {
            echo '<pagebreak>';
        }
    }
    // Assigning the new words (from the URL) to a global value
    $_SERVER["words"] = $words;
    
?>
`.replace(/<endscript>/g, '</' + 'script>').split('<pagebreak>');
pages.pop();

var toLang = "<?php echo ucfirst($GLOBALS["toLang"]); ?>"
var fromLang = "<?php echo ucfirst($GLOBALS["fromLang"]); ?>";

// The list of words whose translation could not be found
var invalidWords = [<?php
    foreach ($_SERVER["INVALID_WORDS"] as $word) {
        if ($word != "") echo "`$word`,";
    }
?>];

// Printing out the invalid words
if (invalidWords.length > 0) {
    result.innerHTML += 'Words whose translation could not be retrieved (if you think this is an error, please let me know):<br/>';
    invalidWords.forEach(function (word) {
        result.innerHTML += `${word}<br />`;
    });
    result.innerHTML += '<br/>';
}

// Putting all the words into a JS array
var words = [<?php
foreach ($newWords as $word) {
    echo "`$word`,";
};
?>];

// Trimming each word and filtering only the valid words
words.forEach(function(word){word = word.trim()});
words = words.filter(word => invalidWords.indexOf(word) == -1);

// Converts HTML from a string into HTML tags
function htmlToElements(html) {
    var template =
    document.createElement('template');
    html = html.trim();
    template.innerHTML = html;
    return template.content.childNodes;
}

// Shorthand for getting an Array out of NodeLists and HTMLCollections
function toArray(slicee) {
    return Array.prototype.slice.call(slicee);
}

// Applying the translation
function applyTranslation(typeSyn, typeTr, obj) {
    if (typeTr) {
        if (typeSyn)
            obj[typeSyn] = typeTr;
        else
            obj.translation = typeTr;
        typeSyn = typeTr = undefined;
    }
}

// Finding the translation
function getTranslation(element) {
    let translations = element.querySelectorAll(':scope > .type-translation');
    let translationTerms = [];
    translations.forEach(function (tr) {
        if (tr)
            translationTerms.push(tr.textContent);
    });
    if (translationTerms.length > 0)
        return translationTerms.join(", ");
}

// Getting the label for the groups
function getLabel(element) {
    let label = element.querySelectorAll(':scope > .lbl');
    if (label.length == 0) label = element.querySelectorAll(':scope > .gramGrp');
    if (label.length == 0) label = element.querySelectorAll(':scope > .form');
    let lbls = [];
    toArray(label).forEach(function (lbl) {
        if (lbl) {
            if (/^[([].*[)\]]$/.test(lbl.textContent))
                lbls.push(lbl.textContent);
            else
                lbls.push(`(${lbl.textContent})`);
        }
    });
    if (lbls.length > 0) {
        return lbls.join(' ');
    }
}

// Get the phrases
function getPhrases(element) {
    var phrases = {};
    toArray(element.querySelectorAll(':scope > .type-phr')).forEach(function (phrase) {
        var curPhrase = {};
        let translation, label, examples;
        if (!isEmpty(examples = getExamples(phrase)))
            curPhrase.examples = examples;
        if (translation = getTranslation(phrase))
            if (isEmpty(examples))
                curPhrase = translation;
            else
                curPhrase.translation = translation;
        if (label = getLabel(phrase))
            phrases[phrase.querySelector('.form').textContent] = curPhrase;
    });
    return phrases;
}

// Get the examples
function getExamples(element) {
    var examples = {}; toArray(element.getElementsByClassName('type-example')).forEach(function (example) {
        let typeSyn, typeTr;
        toArray(example.children).forEach(function (innerChild) {
            let innerClasses = innerChild.className.split(' ');
            if (innerClasses.indexOf('quote') > -1) {
                typeSyn = innerChild.textContent;
            } else if (innerClasses.indexOf('type-translation') > -1) {
                typeTr = innerChild.textContent;
            }
            applyTranslation(typeSyn, typeTr, examples);
        });
    });
    return examples;
}

function isEmpty(obj) {
  return Object.entries(obj).length === 0 && obj.constructor === Object;
}

for (let i = 0; i < pages.length; ++i) {
    var posIndex = 1;
    // Data of the translation
    var translationData = {};

    // Getting the translations from the different parts of speech
    var translationGroups = toArray(htmlToElements(pages[i])).filter(el => el.className == 'hom');

    // Looping through all the translation groups
    translationGroups.forEach(function (curGroup) {
        // Getting the part of speech and making it an object
        let partOfSpeech;
        if (partOfSpeech = curGroup.querySelector(".pos"))
            partOfSpeech = partOfSpeech.textContent;
        else
            partOfSpeech = "word";
        if (translationData[partOfSpeech])
            var p = translationData[`${partOfSpeech} ${++posIndex}`] = {};
        else
            var p = translationData[partOfSpeech] = {};
        // Getting all the possible translations of this part of speech
        let possibleTranslations = toArray(curGroup.children).filter(child => child.className == "sense");

        // Looking through all the possible translations of this part of speech
        possibleTranslations.forEach(function getSenses(curSense, senseParent, preLabel) {
            
            // Checking types so recursion can be successful
            if (typeof(senseParent == "number"))
                senseParent = p;
            if (typeof(preLabel) == "object" || !preLabel)
                preLabel = "";
            
            // Recurse if needed
            let innerSenses = toArray(curSense.querySelectorAll(':scope > .sense'));
            
            if (innerSenses.length > 0) {
                innerSenses.forEach(function(sense) {
                    getSenses(sense, curSense, getLabel(curSense));
                });
                
            }
            
            var currentGroup = {};
            var tempLabel = getLabel(curSense);
            
            var label = preLabel + ' ' + (tempLabel ? tempLabel : `${words[i]} (${partOfSpeech})`);
            label = label.trim();
            
            
            if (showExamples) {
                // Get all examples
                let examples = getExamples(curSense);
                if (!isEmpty(examples))
                    currentGroup.examples = examples;
            }
            
            if (showPhrases) {
                // Get all phrases
                let phrases = getPhrases(curSense);
                if (!isEmpty(phrases))
                    currentGroup.phrases = phrases;
            }
            // Getting all direct translations
            let translation = getTranslation(curSense);
            if (translation) {
                if (typeof examples !== 'undefined' && isEmpty(examples) && typeof phrases !== 'undefined' && isEmpty(phrases))
                    currentGroup = translation;
                else
                    currentGroup.translation = translation;
            } else if (!label && curSense.className == "sense") {
                toArray(curSense.children).filter(ch => ch.className = "re type-phr").forEach(function (child) {
                    getSenses(child, currentGroup);
                });
                return;
            }
                    
            // Applying a label if it exists
            if (label)
                senseParent[label] = currentGroup;
            else if (!isEmpty(currentGroup)) {
                if (!senseParent.translations)
                    senseParent.translations = [];
                senseParent.translations.push(currentGroup);
            }
        });

        let t = p.translations;
        // If only one translation in translation array, extract it out
        if (t && t.length == 1) t = t[0];
        // If object is empty, delete it
        if (isEmpty(p)) {
            delete translationData[partOfSpeech];
        // If there is only a translation key, then make the whole object the translation
        } else if (Object.entries(p).length === 1 && t) {
            translationData[partOfSpeech] = t;
        }
    });
    // Putting it into the larger translation object
    translations[words[i]] = translationData;
}

function printTranslations() {
    let translationStr = '';
    // Looping through all translations
    Object.keys(translations).forEach(function (translation) {
        let word = translation;
        let w = translations[word];
        // String to be put in the result's innerHTML
        Object.keys(w).forEach(function (partOfSpeech) {
            let curTranslations = {};
            let curExamples = {};
            let curUnnamedTranslations = [];
            let curUnnamedExamples = [];
            let globalTranslations = {};
            let pos = translations[word][partOfSpeech];
            if (typeof(pos) == "string") {
                curUnnamedTranslations.push(pos);
            } else {
                if (pos.translation || pos.examples) {
                    if (pos.translation)
                        curUnnamedTranslations.push(pos.translation);
                    else if (showExamples)
                        Object.keys(pos.examples).forEach(function (ex) {
                            curUnnamedExamples.push(pos.examples[ex]);
                        });
                } else {
                    Object.keys(pos).forEach(function recursiveCheck(saying, parent) {
                        if (typeof(parent) == "number")
                            parent = pos;
                        let potentialTranslation = parent[saying];
                        if (typeof(parent[saying]) == "string") {
                            if (/^[([].*[)\]]$/.test(saying))
                                curTranslations[saying] = parent[saying];
                            else if (showPhrases)
                                globalTranslations[saying] = parent[saying];
                            else
                                curUnnamedTranslations.push(parent[saying]);
                        }
                        else if (parent[saying].translation) {
                            if (/^[([].*[)\]]$/.test(saying))
                                curTranslations[saying] = parent[saying].translation;
                            else if (showPhrases)
                                globalTranslations[saying] = parent[saying].translation;
                            else
                                curUnnamedTranslations.push(parent[saying].translation);
                        }
                        if (showExamples && parent[saying].examples) {
                            Object.keys(parent[saying].examples).forEach(function (ex) {
                                curExamples[ex] = parent[saying].examples[ex];
                            });
                        }
                        if (showPhrases && parent[saying].phrases) {
                            Object.keys(parent[saying].phrases).forEach(function (phrase) {
                                recursiveCheck(phrase, parent[saying].phrases);
                            });
                        }
                    });
                }
            }
            
            if (group) {
                if (showLanguageLabel)
                    translationStr += `${fromLang}: `;
                if (!isEmpty(curTranslations) || curUnnamedTranslations.length > 0)
                    translationStr += `${word} (${partOfSpeech})${printSep}`;
                if (showLanguageLabel)
                    translationStr += `${toLang}: `;
                curUnnamedTranslations.forEach(function (word) {
                    translationStr += `${word}, `;
                });
                
                Object.keys(curTranslations).forEach(function (key) {
                    translationStr += `${key}: ${curTranslations[key]}, `;
                });
                
                // Cleaning Trailing Comma
                translationStr = translationStr.trim().slice(0, -1);
                translationStr += '<br/>';
                
                if (showPhrases) {
                    if (!showExamples) translationStr += '<br/>';
                    Object.keys(globalTranslations).forEach(function (key) {
                        translationStr += `${key}${printSep}${globalTranslations[key]}<br />`;
                    });
                }
                
            } else {
                if (curUnnamedTranslations.length > 0) {
                    if (showLanguageLabel)
                        translationStr += `${fromLang}: `;
                    translationStr += `${word} (${partOfSpeech})${printSep}`;
                    if (showLanguageLabel)
                        translationStr += `${toLang}: `;
                    curUnnamedTranslations.forEach(function (word) {
                        translationStr += `${word}, `;
                    });
                    translationStr = translationStr.trim().slice(0, -1);
                    translationStr += '<br />';
                }
                
                Object.keys(curTranslations).forEach(function (key) {
                    if (showLanguageLabel)
                        translationStr += `${fromLang}: `;
                    translationStr += `${word} (${partOfSpeech}) ${key}${printSep}`;
                    if (showLanguageLabel)
                        translationStr += `${toLang}: `;
                    translationStr += `${curTranslations[key]}`;
                    if (showPOSOnBothSides)
                        translationStr += ` (${partOfSpeech})`;
                    if (showUseOnBothSides)
                        translationStr += ` ${key}`;
                    translationStr += '<br />';
                    
                });
                Object.keys(globalTranslations).forEach(function (key) {
                    if (showLanguageLabel)
                        translationStr += `${fromLang}: `;
                    translationStr += `${key}${printSep}`;
                    if (showLanguageLabel)
                        translationStr += `${toLang}: `;
                    translationStr += `${globalTranslations[key]}<br />`;
                });
            }
            if (showExamples) {
                Object.keys(curExamples).forEach(function (ex) {
                    translationStr += `${ex}${printSep}${curExamples[ex]}<br />`;
                });
            }
        });
    });
    result.innerHTML += translationStr;
    textFile = makeTextFile(translationStr);
    if (logObj) {
        console.log(translations);
    }
}

function displayResult() {
    finished.style.display = 'block';
    waiting.style.display = 'none';
    printTranslations();

    let aTag = downloadLink;
    aTag.setAttribute('download', 'Translations');
    aTag.setAttribute('href', textFile);
}

$(function(){displayResult()});

</script>
