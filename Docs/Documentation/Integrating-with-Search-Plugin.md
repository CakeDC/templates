Integrating with Search plugin
==============================

The CakeDC [Search plugin][1] can be easily integrated into baked code. Firstly install the plugin, then add the `-subthemes` option to your commands:

```shell
Console/cake bake model Article              -theme cakedc -parent Author -parentSlug -subthemes Templates.search
Console/cake bake controller Article public  -theme cakedc -parent Author -parentSlug -subthemes Templates.search
Console/cake bake view Article               -theme cakedc -parent Author -parentSlug -subthemes Templates.search
Console/cake bake view Article find          -theme search
```

[1]: https://github.com/CakeDC/search
