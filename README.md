# Website Analyzer 


Website analyser is a project for monitoring website 

for the moment this project is for 

- Testing available URL 

# Name

- Orion Monitoring


## Technology 

- Symfony
- MySQL 

# To do 

- User entity 
- Authentication 
- User -> domain -> available/security/seo -> list domain, checkup... 

# Later 

- Cache (redis)
- Ansible
- Docker 
- Blackfire 
- Webpack Encore
- Tailwind CSS 




# Deploy this project with ansible and docker  





# Start this project 

- docker-compose exec php sh 

- composer install (in php container)
- php bin/console d:d:c (in php container)
- php bin/console d:s:u --force (in php container)

- yarn install  (in php container)
- yarn dev (in php container)

## Feature 

##### Availablity (Each hours)

- Status Code HTTP
- Certificat SSL 
- CDN is valid 
- All link is a https in content

-> Notification ? Who ? 

-> Slack, Discord ... 

##### SEO (Each week)

- find the common backlinks of other competitors

##### Security (Each Month)

- Check if RGPD is ok 
- Check if service is run (with port analyse)

##### API 

- Search link in website (https://algoyo/api/token/domainsearch)
- Search backlink for each request 
- Search if domain is a RGPD compliance 



