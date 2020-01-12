# Photon PHP Framework

Photon is a Lightweight PHP MVC Framework 💡

How to Ignite?
---

To use `Photon` you only need to add theses lines into your index.php folder and create some folders.

```php
require_once(__DIR__ . "/photon.php");
$photon = new Photon(true);
$photon->ignite();
```

Really Simple to Use
---

```php
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
```

Credits
---

Photon is powered by [Clint.Network](https://twitter.com/clint_network).
