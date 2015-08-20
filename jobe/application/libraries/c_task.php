<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ==============================================================
 *
 * C
 *
 * ==============================================================
 *
 * @copyright  2014 Richard Lobb, University of Canterbury
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('application/libraries/LanguageTask.php');

class C_Task extends Task {

    public function __construct($source, $filename, $input, $params) {
        Task::__construct($source, $filename, $input, $params);
        $this->default_params['compileargs'] = array(
            '-Wall',
            '-Werror',
            '-std=c99',
            '-x c');
    }

    public static function getVersion() {
        return 'gcc-4.6.3';
    }

    public function compile() {
        $src = basename($this->sourceFileName);
        $errorFileName = "$src.err";
        $execFileName = "$src.exe";
        $compileargs = $this->getParam('compileargs');
        $cmd = "gcc " . implode(' ', $compileargs) . " -o $execFileName $src -lm 2>$errorFileName";
        exec($cmd, $output, $returnVar);
        if ($returnVar == 0) {
            $this->cmpinfo = '';
            $this->executableFileName = $execFileName;
        }
        else {
            $this->cmpinfo = file_get_contents($errorFileName);
        }
    }

    // A default name for C programs
    public function defaultFileName($sourcecode) {
        return 'prog.c';
    }
    
    
    // The executable is the output from the compilation
    public function getExecutablePath() {
        return "./" . $this->executableFileName;
    }
    
    
    public function getTargetFile() {
        return '';
    }
};
