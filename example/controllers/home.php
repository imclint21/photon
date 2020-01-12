<?php
class Home 
{
    public function index()
    {
        return view();
    }

    /**
     * @route /home/mdr/wtf
     */
    public function about()
    {
        $viewbag = "haha trop insane";
        return view();
    }
}
?>