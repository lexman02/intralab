# Build frontend
FROM node:20-alpine AS frontend-builder
WORKDIR /app/frontend
COPY ./frontend/package.json ./frontend/yarn.lock ./
RUN yarn install
COPY ./frontend .
RUN yarn build && \
    yarn cache clean

# Build backend
FROM golang:alpine AS backend-builder
WORKDIR /app/backend
COPY . .
COPY --from=frontend-builder /app/frontend/dist ./frontend/dist
COPY --from=frontend-builder /app/frontend/embed.go ./frontend/embed.go
RUN go get
RUN go build -o intralab .

# Final image
FROM alpine:3.14
WORKDIR /intralab
COPY --from=backend-builder /app/backend/intralab .
RUN mkdir data
VOLUME /data
EXPOSE 3000
CMD ["/app/intralab"]