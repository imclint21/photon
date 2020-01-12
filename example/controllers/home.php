<?php
class Home 
{
    /**
     * @route /
     */
    public function index()
    {
        return view();
    }

    public function about()
    {
        Photon::$viewbag = "This is the about page.";
        return view();
    }

    /**
     * @route /privacy-policy
     */
    public function privacy()
    {
        return view();
    }

    /**
     * @layout null
     * @route /robots.txt
     */
    public function robot()
    {
        return content("User-agent: *\nAllow: /");
    }
}
?>