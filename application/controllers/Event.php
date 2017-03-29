<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }
    
    // ####################################### //
    // ########## web Page Function ########## //
    // ####################################### //
    public function index()
    {
        $this->booklist();
    }
    public function pre_event()
    {
        $data = array();
        $this->load->view('event/pre_event_170208', $data);
    }
    
    public function swipe()
    {
        $data = array();
        $this->load->view('event/membership_swipe_170221', $data);
    }

    
    public function testlink()
    {
        echo " <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-91558112-1', 'auto');
  ga('send', 'pageview');

</script>

";
        echo "<a href='http://members.eduniety.net/event/pre_event' > membership buy </a>";
    }
}
?>
