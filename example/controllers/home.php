<?php
class Home 
{
    public function index()
    {
        return view();
    }

    public function about()
    {
        $viewbag = "haha trop insane";
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