FROM nginx:1.19-alpine

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
