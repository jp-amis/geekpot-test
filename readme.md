# GeekPot IT Consulting test

The test was made with Lumen framework, the documentation can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Requirements

1. Como visitante eu devo conseguir criar uma conta utilizando meu email e uma senha, e ao concluir com sucesso meu cadastro devo receber um email de confirmação. 
2. Como cliente da API eu devo conseguir autenticar utilizando uma API Key e uma Secret Key geradas automaticamente no momento do meu cadastro. 
3. Como cliente da API meu token de acesso deve se renovar a cada 5 minutos, e expirar após 15 minutos de inatividade. 
4. Como cliente da API eu devo ter um método de lookup, onde posso requisitar a lista de todos os resources e métodos aos quais tenho permissão de acessar. 
5. Como cliente da API eu não posso ter acesso a nenhum registro que não seja de minha propriedade. 
6. Como administrador da API eu devo poder listar e visualizar detalhes de todos os usuários registrados. 
7. Como administrador da API eu devo poder alterar, suspender o acesso e deletar qualquer usuário registrado. 
8. Como administrador da API eu devo poder listar todos os usuários deletados.

## API

All api calls should be prefixed with **/api/v1**

## Register user [POST /users]
+ Request (application/json)

        { 
            "email": "example@example.com",
            "password": "password#123"
        }

+ Response 201 (application/json)
    
    + Headers
    
            Location: /users/4912857
    
    + Body
    
            { "created": true }
                
## License

GeekPot IT Consulting test and the Lumen framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
