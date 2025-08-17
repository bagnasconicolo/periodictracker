#!/bin/bash
# PeriodicTracker Deployment Script
# Run this on your DigitalOcean droplet to deploy updates

set -e

echo "🚀 Starting PeriodicTracker deployment..."

# Configuration
REPO_URL="https://github.com/yourusername/periodictracker.git"
DEPLOY_DIR="/var/www/html"
BACKUP_DIR="/var/backups/periodictracker"

# Create backup of current deployment
echo "📦 Creating backup..."
sudo mkdir -p $BACKUP_DIR
sudo cp -r $DEPLOY_DIR $BACKUP_DIR/backup-$(date +%Y%m%d-%H%M%S) || true

# Pull latest changes from GitHub
echo "📥 Pulling latest changes..."
cd $DEPLOY_DIR
sudo git pull origin main

# Set proper permissions
echo "🔐 Setting file permissions..."
sudo chown -R www-data:www-data $DEPLOY_DIR
sudo chmod -R 755 $DEPLOY_DIR
sudo chmod -R 777 $DEPLOY_DIR/www/html/uploads

# Restart Apache
echo "🔄 Restarting Apache..."
sudo systemctl restart apache2

echo "✅ Deployment complete!"
echo "🌐 Your site should now be updated at your domain"

# Optional: Run database migrations
if [ -f "$DEPLOY_DIR/migrations.sql" ]; then
    echo "🗄️ Running database migrations..."
    mysql -u your_db_user -p your_db_name < $DEPLOY_DIR/migrations.sql
fi