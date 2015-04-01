Usage Example
=============

The following lines will generate the code for Author model, it's associated controller and views.

```shell
Console/cake bake model Author                -theme cakedc -slug
Console/cake bake controller Authors public   -theme cakedc -slug
Console/cake bake view Authors                -theme cakedc -slug
```

The -slug modifier will make the generator do all model searches using a slug field instead of an id. Additionally controller actions will take model slug as parameters and those will get propagated in links into the view templates,

If you have classic Parent - Child model structure you can execute the following commands

```shell
Console/cake bake model Article              -theme cakedc -parent Author -parentSlug -appTestCase
Console/cake bake controller Article public  -theme cakedc -parent Author -parentSlug -appTestCase
Console/cake bake view Article               -theme cakedc -parent Author -parentSlug -appTestCase
```

The previous commands will generate the code Article model using as a requisite the Author slug in function parameters.
