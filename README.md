<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Deploy to Google Cloud Run

This guide explains how to deploy the Laravel application to Google Cloud Run using Docker, Artifact Registry, Cloud SQL, and Google Cloud Storage.

## Prerequisites

Before deploying, make sure you have:

- A Google Cloud Project
- Billing enabled
- Google Cloud SDK (`gcloud`) installed
- Docker installed
- Cloud SQL instance (MySQL)
- Google Cloud Storage bucket (if using file uploads)

---

## 1. Enable Required Google Cloud APIs

Enable all required services:

```bash
gcloud services enable \
run.googleapis.com \
cloudbuild.googleapis.com \
artifactregistry.googleapis.com \
sqladmin.googleapis.com \
storage.googleapis.com
```

---

## 2. Configure Your Google Cloud Project

Set your active project.

```bash
gcloud config set project PROJECT_ID
```

Example:

```bash
gcloud config set project my-laravel-project
```

Verify the active project:

```bash
gcloud config get-value project
```

---

## 3. Create an Artifact Registry Repository

Create a Docker repository to store your application image.

```bash
gcloud artifacts repositories create your-repo-name \
--repository-format=docker \
--location=your-region-deploy
```

Verify:

```bash
gcloud artifacts repositories list
```

---

## 4. Configure Docker Authentication

Allow Docker to push images to Artifact Registry.

```bash
gcloud auth configure-docker your-region-deploy-docker.pkg.dev
```

---

## 5. Build and Push Docker Image

Build the application image using Cloud Build.

```bash
gcloud builds submit \
--tag your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name/backend:latest
```

---

## 6. Deploy to Cloud Run

Deploy the image.

```bash
gcloud run deploy your-deploy-name \
--image your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name/backend:latest \
--region your-region-deploy \
--allow-unauthenticated \
--memory 512Mi \
--cpu 1 \
--port 8080 \
--add-cloudsql-instances PROJECT_ID:your-region-deploy:INSTANCE_NAME
```

Cloud Run will return a public HTTPS URL after deployment.

---

## 7. Configure Environment Variables

Configure Laravel environment variables.

```bash
gcloud run services update your-deploy-name \
--region your-region-deploy \
--update-env-vars \
--APP_NAME=Laravel \
--APP_ENV=production\
--APP_DEBUG=false \
--APP_KEY=YOUR_APP_KEY \
--APP_URL=https://YOUR_CLOUD_RUN_URL \
--DB_CONNECTION=mysql \
--DB_HOST=127.0.0.1 \
--DB_PORT=3306 \
--DB_DATABASE=YOUR_DATABASE \
--DB_USERNAME=YOUR_DATABASE_USERNAME \
--DB_PASSWORD=YOUR_DATABASE_PASSWORD \
--DB_SOCKET=/cloudsql/PROJECT_ID:your-region-deploy:INSTANCE_NAME \
--FILESYSTEM_DISK=local \
--GOOGLE_CLOUD_PROJECT=PROJECT_ID \
--GOOGLE_CLOUD_STORAGE_BUCKET=YOUR_BUCKET \
--JETSTREAM_PROFILE_PHOTO_DISK=gcs \
--API_URL=https://YOUR_PREDICTION_API/predict
```

---

## 8. Grant Storage Permissions

Retrieve the Cloud Run Service Account.

```bash
gcloud run services describe your-deploy-name \
--region your-region-deploy \
--format="value(spec.template.spec.serviceAccountName)"
```

Example output:

```text
123456789-compute@developer.gserviceaccount.com
```

Grant permission to upload objects into Google Cloud Storage.

```bash
gcloud storage buckets add-iam-policy-binding gs://YOUR_BUCKET \
--member="serviceAccount:SERVICE_ACCOUNT_EMAIL" \
--role="roles/storage.objectAdmin"
```

---

## 9. Run Database Migration

Run Laravel database migrations using a Cloud Run Job.

```bash
gcloud run jobs create migrate \
--image your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name/backend:latest \
--region your-region-deploy \
--execute-now \
--command php \
--args artisan,migrate,--force
```

If the job already exists:

```bash
gcloud run jobs execute migrate \
--region your-region-deploy
```

---

## 10. Verify Deployment

Open the Cloud Run URL.

```
https://YOUR_CLOUD_RUN_URL
```

Verify that:

- Home page loads successfully
- Authentication works
- Database connection works
- Profile update works
- Profile photo upload works
- AI prediction feature works

---

# Updating the Application

After making changes to the source code:

Build a new image.

```bash
gcloud builds submit \
--tag your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name/backend:latest
```

Deploy the latest image.

```bash
gcloud run deploy your-deploy-name \
--image your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name/backend:latest \
--region your-region-deploy
```

---

# Useful Commands

## View Cloud Run Logs

```bash
gcloud run services logs read your-deploy-name \
--region your-region-deploy
```

---

## Describe Cloud Run Service

```bash
gcloud run services describe your-deploy-name \
--region your-region-deploy
```

---

## List Cloud Run Services

```bash
gcloud run services list
```

---

## Delete Cloud Run Service

```bash
gcloud run services delete your-deploy-name \
--region your-region-deploy
```

---

## List Artifact Registry Images

```bash
gcloud artifacts docker images list \
your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name
```

---

## Delete an Artifact Registry Image

```bash
gcloud artifacts docker images delete \
your-region-deploy-docker.pkg.dev/PROJECT_ID/your-repo-name/backend:latest
```

---

## List Cloud Run Jobs

```bash
gcloud run jobs list \
--region your-region-deploy
```

---

## Execute Migration Job Again

```bash
gcloud run jobs execute migrate \
--region your-region-deploy
```
