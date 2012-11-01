<?php
class Diglin_Io_File extends Varien_Io_File{

    /**
     * Read a file to result, file or stream
     *
     * If $dest is null the output will be returned.
     * Otherwise it will be saved to the file or stream and operation result is returned.
     *
     * @param string $filename
     * @param string|resource $dest
     * @return boolean|string
     */
    public function read($filename, $dest=null)
    {
        if (!is_null($dest)) {
            @chdir($this->_cwd);
            $result = @copy($filename, $dest);
            @chdir($this->_iwd);
            return $result;
        }

        @chdir($this->_cwd);
        $result = @file_get_contents($filename);
        @chdir($this->_iwd);

        return $result;
    }
    
    /**
     * Write a file from string, file or stream
     *
     * @param string $filename
     * @param string|resource $src
     * @return int|boolean
     */
    public function write($filename, $src, $mode=null)
    {
        if (is_string($src) && is_readable($src)) {
            $src = realpath($src);
            $srcIsFile = true;
        } elseif (is_string($src) || is_resource($src)) {
            $srcIsFile = false;
        } else {
            return false;
        }
        @chdir($this->_cwd);

        if (file_exists($filename)) {
            if (!is_writeable($filename)) {
                printf('File %s don\'t writeable', $filename);
                return false;
            }
        } else {
            if (!is_writable(dirname($filename))) {
                printf('Folder %s don\'t writeable', dirname($filename));
                return false;
            }
        }
        if ($srcIsFile) {
            $result = @copy($src, $filename);
        } else {
            $result = @file_put_contents($filename, $src);
        }
        if (!is_null($mode)) {
            @chmod($filename, $mode);
        }
        @chdir($this->_iwd);
        return $result;
    }
}