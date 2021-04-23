<?php

class IpLogger
{
    public $ip;
    public $user_agent;

    /**
     * IpLogger constructor.
     */
    public function __construct()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return mixed
     */
    public function get_ip()
    {
        return $this->ip;
    }

    /**
     * @param $ip
     * This method is for test purposes only
     */
    public function set_ip($ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     * ToDo Beta, rewrite.
     */
    public function get_region()
    {
        return json_decode(file_get_contents("https://ipinfo.io/{$this->ip}"))->region;
    }

    /**
     * @return mixed
     * ToDo Beta, rewrite.
     */
    public function get_timezone()
    {
        return json_decode(file_get_contents("https://ipinfo.io/{$this->ip}"))->timezone;
    }

    /**
     * @return mixed
     * ToDo Beta, rewrite.
     */
    public function get_hostname()
    {
        return json_decode(file_get_contents("https://ipinfo.io/{$this->ip}"))->hostname;
    }

    /**
     * @return mixed
     * ToDo Beta, rewrite.
     */
    public function get_country()
    {
        return json_decode(file_get_contents("https://ipinfo.io/{$this->ip}"))->country;
    }

    /**
     * @return mixed
     * ToDo Beta, rewrite.
     */
    public function get_city()
    {
        return json_decode(file_get_contents("https://ipinfo.io/{$this->ip}"))->city;
    }

    /**
     * @return string
     */
    public function get_os(): string
    {
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/kalilinux/i' => 'KaliLinux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
            '/Windows Phone/i' => 'Windows Phone'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $this->user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    /**
     * @return string
     */
    public function get_browser(): string
    {
        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/Mozilla/i' => 'Mozila',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/OPR/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/Bot/i' => 'BOT Browser',
            '/Valve Steam GameOverlay/i' => 'Steam',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $this->user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }

    /**
     * @param $filename
     * @param $timezone
     */
    public function write($filename, $timezone): void
    {
        try {
            $date = new DateTime('now', new DateTimeZone($timezone));
        } catch (Exception $e) {
            $date = new DateTime('now');
            echo $e;
        }
        $str = $date->format('Y-m-d H:i:s') . "\t| " . $this->get_ip() . " | OS:" . $this->get_os() . " | BR:" . $this->get_browser() . PHP_EOL;
        file_put_contents($filename, $str, FILE_APPEND | LOCK_EX);
    }

    /**
     * @param $filename
     * @param $timezone
     * BETA. This method affects the speed due to the external api that it uses. ToDo rewrite.
     */
    public function writeExtra($filename, $timezone): void
    {
        try {
            $date = new DateTime('now', new DateTimeZone($timezone));
        } catch (Exception $e) {
            $date = new DateTime('now');
            echo $e;
        }
        $str = $date->format('Y-m-d H:i:s') . "\t| " . $this->get_ip() . " | CN:" . $this->get_country() . "-" . $this->get_city() . " | OS:" . $this->get_os() . " | BR:" . $this->get_browser() . PHP_EOL;
        file_put_contents($filename, $str, FILE_APPEND | LOCK_EX);
    }
}