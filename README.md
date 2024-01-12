# Bylith-  Web Servers Monitoring System

## About this project 
this is a system built to give you the ability to monitor the status of servers,
you can use it for different kinds of servers like HTTP/S, SSH, and FTP/S, and get the status by different methods, based on Latency, Status Code Response, SSH time out, and FTP connections, and you can get Email notifications for servers Unhealthy to your controller team!


## Using API
### You can easily Add, Get, Update, and Delete:
- Webservers List and History logs
- API Access tokens for more people
- Emails notification list for your control team
  
### API Reference
Every request should have a **Token** and **Name** in the header:  Bylith-Name, Bylith-Token 
```
'Bylith-Name': 'nerya', 
'Bylith-Token': '*********gfg', 
```


## Webserver
### Get All

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/webservers/get
``` 

### Get One with 10 Recently History log

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/webservers/get/?q=HTTP Server
``` 

### Add

**Type** 
``` POST ```
**URL** 
```{https//:yoururl.com}/api/v1.0/webservers/add``` 

**Body**
```
{
    "name": "HTTP Server",
    "address": "example.com",
    "disabled": false,
    "type": "HTTPS"
}
```

### Update

**Type** 
``` PUT ```
**URL** 
```{https//:yoururl.com}/api/v1.0/webservers/update``` 

**Body**
```
{
    "name": "HTTP Server",
    "address": "example.com",
    "disabled": false,
    "type": "HTTPS"
}
```

### Delete
**Type** 
``` DELETE ```

**URL** 
```{https//:yoururl.com}/api/v1.0/webservers/delete``` 

**Body**
```
{
    "name": "HTTP Server"
}
```

## History 

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/history/get/?q=name server
``` 



## API Tokens

### Get All Names

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/tokens/get
``` 

### Get All Names

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/tokens/get
``` 

### Add
### You can set permission (2 - Manege API Tokens, Manege Emails, Manege Webservers, Get History. 1 - Manege Webservers, Get History)

**Type** 
``` POST ```
**URL** 
```{https//:yoururl.com}/api/v1.0/tokens/add``` 

**Body**
```
{
    "name": "name-token",
    "permission": 1
}
```

### Delete
**Type** 
``` DELETE ```

**URL** 
```{https//:yoururl.com}/api/v1.0/tokens/delete``` 

**Body**
```
{
   "name": "name-token"
}
```



## Email Notifications 

### Get All 

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/emails/get
``` 

### Get All Names

**Type** 
``` GET ```
**URL** 
```
{https//:yoururl.com}/api/v1.0/emails/get
``` 

### Add

**Type** 
``` POST ```
**URL** 
```{https//:yoururl.com}/api/v1.0/emails/add``` 

**Body**
```
{
    "name": "name",
    "email": "name@example.com"
}
```

### Delete
**Type** 
``` DELETE ```

**URL** 
```{https//:yoururl.com}/api/v1.0/emails/delete``` 

**Body**
```
{
   "name": "name"
}
```


## How to run it? 

