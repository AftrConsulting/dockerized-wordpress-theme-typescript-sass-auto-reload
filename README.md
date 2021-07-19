# Dockerized Wordpress Theme With TypeScript, Sass, and Auto-Reload Support

# Features

1. Composer ready
2. Typescript support
3. Sass support
4. Auto Reload
5. Dockerized

# Steps

1. Create an .env file with those fields.

```
MARIADB_USER=
MARIADB_DATABASE=
MARIADB_PASSWORD=
MARIADB_ROOT_PASSWORD=
GTM_TAG=
WP_URL=http://localhost:8181
```

2. Do: sh start.sh

# Common Bugs

If you get a permission error with docker replace the user id from 1000 to your current user id.