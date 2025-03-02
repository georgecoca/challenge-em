FROM node:latest

WORKDIR /app

#ARG VITE_BACKEND_URL
#ENV VITE_BACKEND_URL=$VITE_BACKEND_URL

COPY . .

RUN npm install

EXPOSE 3000

CMD ["npm", "run", "dev"]