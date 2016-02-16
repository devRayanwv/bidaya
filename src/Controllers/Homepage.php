<?php
/**
 * User: Rayan Alamer
 * Date: 15/01/16
 * Time: 5:43 PM
 */

namespace Bidaya\Controllers;
use Http\RequestInterface;
use Http\ResponseInterface;
use Bidaya\App\Controller;
use Spot\Locator;
class Homepage extends Controller
{
    private $response;
    private $request;
    private $spot;

    /**
     * Homepage constructor.
     * @param $response
     */
    public function __construct(ResponseInterface $response, RequestInterface $request, Locator $spot)
    {
        $this->spot = $spot;
        $this->response = $response;
        $this->request = $request;
        parent::__construct();
    }

    public function index()
    {

        $this->response->view('index.php',['data' => ['val1','val2','val3']]);
    }

    public function install()
    {
        $postMapper = $this->spot->mapper('Bidaya\Entities\Post');
        $postMapper->migrate();
    }
}