User Dependent Actions
======================

If you want to restrict actions or data modification only to the owning users of each record you should add the `-user` option to your commands, this options takes a parameter as the name of the model that represents users in your applications.

```shell
Console/cake bake model Article              -theme cakedc -parent Author -parentSlug -subthemes Templates.search -user User -appTestCase
Console/cake bake controller Article public  -theme cakedc -parent Author -parentSlug -subthemes Templates.search -user User -appTestCase
Console/cake bake view Article               -theme cakedc -parent Author -parentSlug -subthemes Templates.search -user User -appTestCase
Console/cake bake view Article find          -theme search
```
