<?php
class Home 
{
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
}
?>