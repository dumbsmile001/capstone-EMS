# Required Packages for Event Management System

## Already Installed ✓
- **Laravel Framework** (^12.0)
- **Laravel Jetstream** (^5.3) - Authentication scaffolding
- **Laravel Sanctum** (^4.0) - API authentication
- **Livewire** (^3.6.4) - Reactive components
- **Spatie Laravel Permission** (^6.23) - Role-based permissions
- **Laravel DomPDF** (^3.1) - PDF generation for receipts/tickets
- **Endroid QR Code** (^6.0) - QR code generation for tickets

## Recommended Packages to Install

### 1. Chart.js (for Organizer Dashboard charts) ⚠️ **REQUIRED**
**Package:** `chart.js`
**Installation:**
```bash
npm install chart.js
```

**Why:** The Organizer Dashboard displays:
- Participant Report (Pie Chart) showing year level distribution
- Events per Month (Bar Chart) showing event statistics

**Usage:** The organizer dashboard view already has placeholder canvas elements ready for Chart.js integration.

### 2. Alpine.js (Already included with Livewire) ✓
- Alpine.js is automatically included with Livewire 3
- No additional installation needed

### 3. SweetAlert2 (Optional - for better modals/alerts) 💡
**Package:** `sweetalert2`
**Installation:**
```bash
npm install sweetalert2
```

**Why:** Better user experience for confirmations and alerts (e.g., "Are you sure you want to cancel registration?")

### 4. Laravel Excel (Optional - for exports) 💡
**Package:** `maatwebsite/excel`
**Installation:**
```bash
composer require maatwebsite/excel
```

**Why:** Useful for exporting event registrations, user lists, reports to Excel/CSV

### 5. Intervention Image (Optional - for image handling) 💡
**Package:** `intervention/image`
**Installation:**
```bash
composer require intervention/image
```

**Why:** Better image processing for event banners, user profile photos, event attachments

## Installation Commands Summary

### Required (Must Install):
```bash
npm install chart.js
```

### Optional (Recommended):
```bash
npm install sweetalert2
composer require maatwebsite/excel
composer require intervention/image
```

## Next Steps

1. **Install Chart.js** before testing the Organizer Dashboard:
   ```bash
   npm install chart.js
   ```

2. **Update `resources/js/app.js`** to import Chart.js:
   ```javascript
   import Chart from 'chart.js/auto';
   window.Chart = Chart;
   ```

3. **Implement charts** in `resources/views/livewire/organizer-dashboard.blade.php` (chart placeholders are ready)

4. **Run build** to compile assets:
   ```bash
   npm run build
   # or for development:
   npm run dev
   ```

