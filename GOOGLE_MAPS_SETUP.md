# Google Maps Setup Guide for Admin Dashboard

This guide explains how to set up and configure the Google Maps feature in your admin dashboard.

## 🗺️ Features

The Google Maps integration provides:
- Interactive map showing your resort location
- Custom resort marker with info window
- Resort location information panel
- Contact details and operating hours
- Responsive design for all devices

## 🔑 Getting a Google Maps API Key

### 1. Create a Google Cloud Project
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable billing for your project

### 2. Enable Maps JavaScript API
1. In the Google Cloud Console, go to "APIs & Services" > "Library"
2. Search for "Maps JavaScript API"
3. Click on it and press "Enable"

### 3. Create API Credentials
1. Go to "APIs & Services" > "Credentials"
2. Click "Create Credentials" > "API Key"
3. Copy your new API key
4. (Optional) Restrict the API key to your domain for security

## ⚙️ Configuration

### 1. Environment Variables
Add these to your `.env` file:

```env
# Google Maps Configuration
GOOGLE_MAPS_API_KEY=YOUR_ACTUAL_API_KEY_HERE

# Resort Location Settings
RESORT_LATITUDE=25.7617
RESORT_LONGITUDE=-80.1918
RESORT_NAME="Your Resort Name"
RESORT_ADDRESS="Your Resort Address"
MAP_ZOOM_LEVEL=15

# Resort Contact Information
RESORT_PHONE="+1 (555) 123-4567"
RESORT_EMAIL="info@yourresort.com"
CHECK_IN_TIME="3:00 PM"
CHECK_OUT_TIME="11:00 AM"
FRONT_DESK_HOURS="24/7"
```

### 2. Update Coordinates
To find your resort's coordinates:
1. Go to [Google Maps](https://maps.google.com)
2. Search for your resort location
3. Right-click on the exact location
4. Select the coordinates that appear
5. Update `RESORT_LATITUDE` and `RESORT_LONGITUDE` in your `.env` file

### 3. Customize Resort Information
Update the following fields in your `.env` file:
- `RESORT_NAME`: Your resort's name
- `RESORT_ADDRESS`: Full address
- `RESORT_PHONE`: Contact phone number
- `RESORT_EMAIL`: Contact email address
- `CHECK_IN_TIME`: Standard check-in time
- `CHECK_OUT_TIME`: Standard check-out time
- `FRONT_DESK_HOURS`: Front desk availability

## 🎨 Customization Options

### Map Settings
You can customize the map appearance by editing `config/maps.php`:

```php
'map_settings' => [
    'map_type' => 'roadmap', // Options: roadmap, satellite, hybrid, terrain
    'show_controls' => true,  // Show/hide map controls
    'show_poi_labels' => false, // Show/hide points of interest labels
    'custom_styles' => [
        // Custom map styling
    ]
]
```

### Marker Customization
Customize the resort marker in `config/maps.php`:

```php
'marker' => [
    'icon_color' => '#EF4444', // Marker color (hex)
    'size' => 32,               // Marker size in pixels
    'title' => 'Resort Location' // Marker tooltip
]
```

## 🚀 Usage

### Admin Dashboard
The map automatically appears in your admin dashboard with:
- Resort location marker
- Interactive info window
- Real-time coordinates display
- Full map controls (zoom, street view, etc.)

### Responsive Design
The map is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile devices

## 🔒 Security Considerations

### API Key Restrictions
1. **HTTP Referrers**: Restrict your API key to your domain
2. **API Restrictions**: Limit to only Maps JavaScript API
3. **Billing Alerts**: Set up billing alerts to monitor usage

### Example Restrictions
```
Application restrictions:
- HTTP referrers (web sites)
- *.yourdomain.com/*
- *.yourdomain.com/*

API restrictions:
- Maps JavaScript API
```

## 🐛 Troubleshooting

### Common Issues

#### 1. Map Not Loading
- Check if your API key is correct
- Verify the Maps JavaScript API is enabled
- Check browser console for JavaScript errors

#### 2. Wrong Location
- Verify coordinates in your `.env` file
- Check if coordinates are in decimal format (not degrees/minutes/seconds)
- Test coordinates in Google Maps first

#### 3. API Key Errors
- Ensure billing is enabled on your Google Cloud project
- Check if API key has proper restrictions
- Verify the Maps JavaScript API is enabled

### Debug Mode
Enable debug mode in your `.env` file:
```env
APP_DEBUG=true
```

## 📱 Mobile Optimization

The map is optimized for mobile devices with:
- Touch-friendly controls
- Responsive sizing
- Mobile-optimized interactions

## 🔄 Updates

### Configuration Changes
After updating your `.env` file:
1. Clear Laravel cache: `php artisan cache:clear`
2. Clear config cache: `php artisan config:clear`
3. Refresh your admin dashboard

### API Key Rotation
To rotate your API key:
1. Create a new API key in Google Cloud Console
2. Update `GOOGLE_MAPS_API_KEY` in your `.env` file
3. Restrict the old key and delete it after testing

## 📞 Support

If you encounter issues:
1. Check the troubleshooting section above
2. Verify your Google Cloud Console settings
3. Check Laravel logs for errors
4. Ensure all environment variables are set correctly

## 🎯 Best Practices

1. **API Key Security**: Never commit API keys to version control
2. **Usage Monitoring**: Set up billing alerts in Google Cloud Console
3. **Regular Updates**: Keep your coordinates and resort information current
4. **Testing**: Test map functionality after configuration changes
5. **Backup**: Keep a backup of your working configuration

---

**Note**: This feature requires an active internet connection and a valid Google Maps API key to function properly.
