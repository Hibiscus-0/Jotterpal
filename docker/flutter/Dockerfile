# ---- Stage 1: build Flutter web ----
FROM ghcr.io/cirruslabs/flutter:stable AS build
WORKDIR /app

COPY frontend/pubspec.* ./
RUN flutter pub get

COPY frontend/ ./
RUN flutter build web --release

# ---- Stage 2: Nginx serves the build ----
FROM nginx:alpine
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=build /app/build/web /usr/share/nginx/html