# Fix: Webhook Timeout - Defer Thumbnail Generation

## Problem
Webhook requests to `pnty_jobs_api` endpoint were timing out after 20 seconds when processing job ads with images. The synchronous thumbnail generation (`wp_generate_attachment_metadata()`) was blocking the webhook response.

## Solution
- **Defer thumbnail generation** during webhook requests using WordPress `shutdown` hook
- **Optimize image download** by replacing `file_get_contents()` with `wp_remote_get()` (10s timeout)
- **Send response immediately** (1-2 seconds) and generate thumbnails asynchronously

## Changes
- Added `is_webhook_request()` to detect webhook API calls
- Added `generate_attachment_metadata_async()` for deferred processing
- Modified `upload_url_image()` and `upload_base64_image()` to defer thumbnails during webhooks
- Normal WordPress uploads unchanged (thumbnails still generated immediately)

## Performance
- **Before**: 20+ seconds (timeout)
- **After**: 1-2 seconds response time
- Thumbnails generated within seconds after response

## Testing
1. Send webhook POST with image data → verify 1-2s response
2. Check images saved correctly → verify attachment meta set
3. Wait 5-10s → verify thumbnails generated
4. Test WordPress admin uploads → verify immediate thumbnail generation (unchanged)

## Backward Compatibility
✅ No breaking changes - only affects webhook requests, normal WordPress behavior unchanged.

