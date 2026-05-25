<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="label">Coupon code</label>
        <input name="code" value="{{ old('code', $coupon->code) }}" class="input" required>
    </div>
    <div>
        <label class="label">Type</label>
        <select name="type" class="input">
            <option value="percent" @selected(old('type', $coupon->type) === 'percent')>Percent</option>
            <option value="fixed" @selected(old('type', $coupon->type) === 'fixed')>Fixed</option>
        </select>
    </div>
    <div>
        <label class="label">Value</label>
        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" class="input" required>
    </div>
    <div>
        <label class="label">Minimum order amount</label>
        <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" class="input">
    </div>
    <div>
        <label class="label">Max discount</label>
        <input type="number" step="0.01" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" class="input">
    </div>
    <div>
        <label class="label">Usage limit</label>
        <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" class="input">
    </div>
    <div>
        <label class="label">Per user limit</label>
        <input type="number" name="per_user_limit" value="{{ old('per_user_limit', $coupon->per_user_limit ?? 1) }}" class="input">
    </div>
    <div>
        <label class="label">Starts at</label>
        <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($coupon->starts_at)->format('Y-m-d\TH:i')) }}" class="input">
    </div>
    <div>
        <label class="label">Expires at</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at', optional($coupon->expires_at)->format('Y-m-d\TH:i')) }}" class="input">
    </div>
    <div class="flex items-center gap-3 pt-8">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active ?? true))>
        <label class="text-sm text-stone-700">Active</label>
    </div>
</div>
