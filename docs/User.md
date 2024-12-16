# USER API

## Register 
Endpoint: Poat/api/user


request boy:

```json
{
    "username": "VicmenD",
    "password": "Victor2",
    "name" : "Victor"
}
```

Response body(success):
```json
{
  "data" : "success"
}
```

Response body (failed):
```json
{
  "data" : "error"
}
```

Request Body (Failed):
```json
{
    "data": "Username Tidak Boleh Kosong"
}
```

## Login

Endpoint: POST
Request Body:
Response Body:(success)
Response Body:(Failed)

## Get Current User

## Update User

## Logout User
