<?php

namespace App\Support;

/**
 * Class ControllerSecurity
 */
class Security
{
    private $_add_empty;
    private $_filteredUri;
    private $_filteredPost;
    private $_filteredGet;
    private $_filteredSession;
    private $_filteredParams;
    private $_argsGet;
    private $_argsPost;
    private $_argsSession;

    /**
     * Security constructor.
     * @param $app
     * @param array $args
     */
    public function __construct()
    {
        $this->_init();
    }

    /**
     * @param array $args
     * @return void
     */
    private function _init($args = null)
    {

        if ($args) {
            $this->_argsGet     = $args['get'];
            $this->_argsPost    = $args['post'];
            $this->_argsSession = $args['session'];
        }

        $this->_filteredUri = array_slice(explode('/', filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL)), 0);
        $index = count($this->_filteredUri) - 1;
        $this->_filteredUri[$index] = urldecode($this->_filteredUri[$index]);
        return null;
    }

    public function __invoke($args = [])
    {
        $this->_init($args);
    }

    // $key = int , @param, if is_int filtered[0]

    /**
     * @param null $key
     * @return mixed|null
     */
    public function getFilteredUri($key = null)
    {
        if ($key === null)                      return $this->_filteredUri;
        if (isset($this->_filteredUri[$key]))   return $this->_filteredUri[$key];
        return null;
    }

    /**
     * @param null $key
     * @return mixed|null
     */
    public function getFilteredPost($key = null)
    {
        $inputFilters           = config('security.post');
        $this->_filteredPost    = filter_input_array(INPUT_POST, $inputFilters, $this->_add_empty);

        if ($key === null)                      return $this->_filteredPost;
        if (isset($this->_filteredPost[$key]))  return $this->_filteredPost[$key];
        return null;
    }

    /**
     * @param null|string $key
     * @return mixed|null
     */
    public function getFilteredGet($key = null)
    {
        $inputFilters           = config('security.get');
        $this->_filteredGet     = filter_input_array(INPUT_GET, $inputFilters, $this->_add_empty);

        if ($key === null)                      return $this->_filteredGet;
        if (isset($this->_filteredGet[$key]))   return $this->_filteredGet[$key];
        return null;
    }

    /**
     * @param $array
     * @return mixed|null
     */
    public function getFilteredParams($array = null)
    {
        if ($array !== null) {
            $inputFilters                   = config('security.post');
            $this->_filteredParams          = filter_var_array($array, $inputFilters, $this->_add_empty);
            return $this->_filteredParams;
        }
        if ($array === null)                        return $this->_filteredParams;
        return null;
    }

    protected function filterSQL($str)
    {
        return str_replace('`', '', $str);
    }

    public function setSQLValue($param, $value)
    {
        return array(':' . $param => $value);
    }

    public function setSQLParameter($param): string
    {
        return '`' . $param . '` = :' . $param;
    }

    public function prepareSQLParameters($get = null) : string
    {
        $sqlParams = '';

        if ($get) {
            if (is_array($get))
            {
                $getKeys = array_keys($get);

                foreach ($getKeys as $param) {
                    $sqlParams .= $this->setSQLParameter($param) . ' AND ';
                }

                $sqlParams = substr($sqlParams, 0, -4);
            } else {
                $sqlParams = $this->setSQLParameter($get);
            }
        }
        return $sqlParams;
    }

    public function prepareSQLValues($array = null) : array
    {
        var_dump($array);
        $keyArrays = [];
        $valuesArray = [];

        if ($array) {
            foreach ($array as $key => $value) {
                $keyArrays[]    =   ':' . $key;
                $valuesArray[]  =   $value;
            }
        }
        return array_combine($keyArrays, $valuesArray);
    }

    /**
     * @param null|string $key
     * @return mixed|null
     */
    public function getFilteredSession($key = null)
    {
        throw_when(isset($this->_filteredSession), 'Session not found');
        if ($key === null)                          return $this->_filteredSession;
        if (isset($this->_filteredSession[$key]))   return $this->_filteredSession[$key];
        return null;
    }

    protected function setFilteredSession()
    {
        if (isset($_SERVER['HTTPS'])) {
            config('session.cookies');


            session_set_cookie_params(
                COOKIE_LIFETIME,
                COOKIE_PATH,
                COOKIE_ROOT_DOMAIN,
                COOKIE_SECURE,
                COOKIE_HTTPONLY
            );
            session_name(COOKIE_NAME);

            // Check if session exists
            session_start(); // TODO WORKS AS MIDDLEWARE?
            dump($_SESSION);

            // Refresh session timer each page loading
            setcookie(session_name(), session_id(), time() + COOKIE_LIFETIME);
            dump($_COOKIE);

            return $this->_filteredSession = filter_input_array(INPUT_SESSION, $this->_argsSession, $this->_add_empty);
            // filter_var_array
        }
        throw_when(isset($_SERVER['HTTPS']), 'Require HTTPS');
    }
}


/*public function getFilteredColumn()
{
    $args = $this->getFilteredGet('column');
    dd($args);
    foreach ($args as $keys)
    {
        $keyExtract = explode(',', $keys);
        $allowed = filters('security.allowedSQL');

        $setStr = "";

        foreach ($keyExtract as $arg) {
            if (in_array($arg, $allowed))
                $setStr .= $this->filterSQL($arg) . ',';
        }
        dd(substr($setStr, 0, -1));
    }
}*/
