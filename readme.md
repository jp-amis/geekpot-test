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

All api calls should be prefixed with **/api/v1**. In all endpoints but the /auth the signature part of the Authorization header has to be the parameters json encoded in sha1 using hmac and API_SECRET as the key. If there is no body or parameters in the query string it should be encrypted this string "{}".

## Register user [POST /users]

Register a new user

| Parameter | Description                                         | Required | Type    | Default   |
|-----------|-----------------------------------------------------|----------|---------|-----------|
| email   | Valid e-mail for the user | false    | string |  -    |
| password   | Password for the user | false    | string |  -    |



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

## Authentication [POST /auth]

The signature on the Authorization header is composed by the API_KEY in sha1 user hmac and API_SECRET as the key

+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE

+ Response 204
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN

## List Users [GET /users]

List all users from the database.

| Parameter | Description                                         | Required | Type    | Default   |
|-----------|-----------------------------------------------------|----------|---------|-----------|
| deleted   | If true makes the api return only the deleted users | false    | boolean | false     |
| page      | Page number if the limit parameter is passed        | false    | integer | 1         |
| limit     | Limit of records to return                          | false    | integer | unlimited |


+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE
            
	+ Query
	
    		?page=4&limit=3

+ Response 200
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN
    
    + Body
    
    		{
            	"data": [
              	    {
                    "id": 12415,
                    "email": "example@example.com",
                    "created_at: "1975-12-25T14:15:16-05:00"
                    },
                    {
                    "id": 51215,
                    "email": "example2@example.com",
                    "created_at: "1975-11-25T14:15:16-05:00"
                    },
                    {
                    "id": 32615,
                    "email": "example3@example.com",
                    "created_at: "1975-01-25T14:15:16-05:00"
                    }
                ],
                "total": 100
            }

## Get User data [GET /users/:id]

Show data from the user especified in :id

| Parameter | Description                                         | Required | Type    | Default   |
|-----------|-----------------------------------------------------|----------|---------|-----------|
| id   | Id of the user to get data from | true    | integer |  -    |


+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE
            
	+ Path
	
    		/12415

+ Response 200
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN
    
    + Body
    
    		{            	               
        	    "id": 12415,
    	        "email": "example@example.com",
	            "created_at: "1975-12-25T14:15:16-05:00"                
            }


## Delete User [DELETE /users/:id]

Delete the user especified in :id

| Parameter | Description                                         | Required | Type    | Default   |
|-----------|-----------------------------------------------------|----------|---------|-----------|
| id   | Id of the user to be deleted | true    | integer |  -    |


+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE
            
	+ Path
	
    		/12415

+ Response 200
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN
    
    + Body
    
    		{            	               
        	    "deleted": true
            }


## Update User [PATCH /users/:id]

Update data from the user especified in :id

| Parameter | Description                                         | Required | Type    | Default   |
|-----------|-----------------------------------------------------|----------|---------|-----------|
| id   | Id of the user to be deleted | true    | integer |  -    |
| email   | Valid e-mail for the user | false    | string |  -    |
| password   | Password for the user | false    | string |  -    |


+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE
            
	+ Path
    		/12415
            
    + Body
    
		    { 
            "email": "example_new@example.com",
            "password": "newPassword#123"
        	}

+ Response 200
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN
    
    + Body
    
    		{            	               
        	    "updated": true
            }


## Update User [PATCH /users/:id]

Revoke all access tokens from a user

| Parameter | Description                                         | Required | Type    | Default   |
|-----------|-----------------------------------------------------|----------|---------|-----------|
| id   | Id of the user to revoke access from | true    | integer |  -    |


+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE
            
	+ Path
    		/12415
            

+ Response 200
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN
    
    + Body
    
    		{            	               
        	    "access_revoked": true
            }


## Resources [GET /resources]

Get all accessable resources for the user


+ Request (application/json)
    + Headers
        
		    Authorization: Bearer API_KEY:SIGNATURE
            
+ Response 200
    
    + Headers
    
		    Authorization: Bearer ACCESS_TOKEN
    
    + Body
    
    		{
            "host": "dev.geekpot.com.br",
            "basePath": "/api/v1",
            "paths": {
              "/users/461827541": {
                "get": {
                  "summary": "Show your data",
                  "parameters": []
                },
                "patch": {
                  "summary": "Update your data",
                  "parameters": [
                    {
                      "name": "email",
                      "in": "body",
                      "description": "Valid e-mail for the user",
                      "required": false,
                      "type": "string"
                    },
                    {
                      "name": "password",
                      "in": "body",
                      "description": "Password for the user",
                      "required": false,
                      "type": "string"
                    }
                  ]
                }
              }
            }
          }





## License

GeekPot IT Consulting test and the Lumen framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
