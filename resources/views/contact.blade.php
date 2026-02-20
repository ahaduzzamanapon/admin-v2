@extends('layouts.shop')

@section('title', 'Contact Us')

@section('content')
<div class="container" style="padding:40px 0 56px;">

    {{-- Page Header --}}
    <div style="margin-bottom:32px; text-align:center;">
        <div style="font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:var(--primary); margin-bottom:8px;">Get In Touch</div>
        <h1 style="font-size:2.2rem; font-weight:800; color:var(--text); margin-bottom:10px;">Contact Us</h1>
        <p style="color:var(--text-muted); max-width:500px; margin:0 auto;">Have a question, feedback or need support? We'd love to hear from you. Fill in the form and we'll get back to you within 24 hours.</p>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1.6fr; gap:28px; align-items:start;">

        {{-- ── INFO CARDS ──────────────────────────── --}}
        <div style="display:flex; flex-direction:column; gap:16px;">

            @php
                $info = [
                    ['fa-location-dot', '#2563eb', 'Our Address',    $themeSettings['address'] ?? '123 Commerce Street, Dhaka 1200, Bangladesh'],
                    ['fa-phone',        '#10b981', 'Phone Number',   $themeSettings['phone']   ?? '+880 1700-000000'],
                    ['fa-envelope',     '#f59e0b', 'Email Address',  $themeSettings['email']   ?? 'support@example.com'],
                ];
            @endphp

            @foreach($info as [$icon, $color, $label, $value])
            <div style="background:#fff; border:1px solid var(--border); border-radius:var(--radius); padding:20px 22px; display:flex; align-items:flex-start; gap:16px; box-shadow:var(--shadow);">
                <span style="width:44px; height:44px; border-radius:var(--radius); background:{{ $color }}18; color:{{ $color }}; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0;">
                    <i class="fa {{ $icon }}"></i>
                </span>
                <div>
                    <div style="font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">{{ $label }}</div>
                    <div style="font-weight:600; color:var(--text); font-size:.92rem;">{{ $value }}</div>
                </div>
            </div>
            @endforeach

            {{-- Business Hours --}}
            <div style="background:#fff; border:1px solid var(--border); border-radius:var(--radius); padding:20px 22px; box-shadow:var(--shadow);">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
                    <span style="width:44px; height:44px; border-radius:var(--radius); background:#7c3aed18; color:#7c3aed; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0;">
                        <i class="fa fa-clock"></i>
                    </span>
                    <div style="font-weight:700; font-size:.9rem;">Business Hours</div>
                </div>
                @foreach([
                    ['Saturday – Thursday', '9:00 AM – 8:00 PM'],
                    ['Friday', '2:00 PM – 8:00 PM'],
                ] as [$day, $hours])
                <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border); font-size:.84rem;">
                    <span style="color:var(--text-muted);">{{ $day }}</span>
                    <span style="font-weight:600;">{{ $hours }}</span>
                </div>
                @endforeach
            </div>

            {{-- Social Links --}}
            @if(!empty($themeSettings['facebook']) || !empty($themeSettings['instagram']) || !empty($themeSettings['twitter']))
            <div style="background:#fff; border:1px solid var(--border); border-radius:var(--radius); padding:20px 22px; box-shadow:var(--shadow);">
                <div style="font-weight:700; font-size:.9rem; margin-bottom:14px;">Follow Us</div>
                <div style="display:flex; gap:10px;">
                    @if(!empty($themeSettings['facebook']))
                    <a href="{{ $themeSettings['facebook'] }}" style="width:38px; height:38px; border-radius:50%; background:#1877f2; color:#fff; display:flex; align-items:center; justify-content:center;" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($themeSettings['instagram']))
                    <a href="{{ $themeSettings['instagram'] }}" style="width:38px; height:38px; border-radius:50%; background:#e1306c; color:#fff; display:flex; align-items:center; justify-content:center;" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($themeSettings['twitter']))
                    <a href="{{ $themeSettings['twitter'] }}" style="width:38px; height:38px; border-radius:50%; background:#1da1f2; color:#fff; display:flex; align-items:center; justify-content:center;" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- ── CONTACT FORM ────────────────────────── --}}
        <div style="background:#fff; border:1px solid var(--border); border-radius:var(--radius); padding:36px 36px 32px; box-shadow:var(--shadow);">
            <div style="font-size:1.2rem; font-weight:800; margin-bottom:6px;">Send Us a Message</div>
            <p style="color:var(--text-muted); font-size:.85rem; margin-bottom:28px;">Fill in the details below and we'll respond as soon as possible.</p>

            {{-- Alert box --}}
            <div id="contact-alert" style="display:none; padding:14px 18px; border-radius:var(--radius-sm); margin-bottom:20px; font-size:.9rem; font-weight:500;"></div>

            <form id="contact-form" novalidate>
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label class="form-label" for="contact_name">Full Name <span style="color:var(--danger)">*</span></label>
                        <input type="text" id="contact_name" name="name" class="form-control" placeholder="Your full name" required>
                        <div class="field-error" data-field="name" style="color:var(--danger); font-size:.78rem; margin-top:4px; display:none;"></div>
                    </div>
                    <div>
                        <label class="form-label" for="contact_email">Email Address <span style="color:var(--danger)">*</span></label>
                        <input type="email" id="contact_email" name="email" class="form-control" placeholder="your@email.com" required>
                        <div class="field-error" data-field="email" style="color:var(--danger); font-size:.78rem; margin-top:4px; display:none;"></div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label class="form-label" for="contact_phone">Phone Number</label>
                        <input type="tel" id="contact_phone" name="phone" class="form-control" placeholder="+880 1xxx-xxxxxx">
                    </div>
                    <div>
                        <label class="form-label" for="contact_subject">Subject <span style="color:var(--danger)">*</span></label>
                        <select id="contact_subject" name="subject" class="form-control" required>
                            <option value="">-- Select subject --</option>
                            <option value="General Enquiry">General Enquiry</option>
                            <option value="Order & Delivery">Order &amp; Delivery</option>
                            <option value="Product Question">Product Question</option>
                            <option value="Return & Refund">Return &amp; Refund</option>
                            <option value="Technical Support">Technical Support</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="field-error" data-field="subject" style="color:var(--danger); font-size:.78rem; margin-top:4px; display:none;"></div>
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label" for="contact_message">Your Message <span style="color:var(--danger)">*</span></label>
                    <textarea id="contact_message" name="message" class="form-control" rows="5" placeholder="Write your message here..." required style="resize:vertical;"></textarea>
                    <div class="field-error" data-field="message" style="color:var(--danger); font-size:.78rem; margin-top:4px; display:none;"></div>
                </div>

                <button type="submit" id="contact-submit" style="display:inline-flex; align-items:center; gap:10px; background:var(--primary); color:#fff; border:none; padding:13px 32px; border-radius:var(--radius); font-weight:700; font-size:.95rem; cursor:pointer; transition:var(--transition); width:100%; justify-content:center;">
                    <span id="submit-icon"><i class="fa fa-paper-plane"></i></span>
                    <span id="submit-text">Send Message</span>
                    {{-- Loader spinner (hidden by default) --}}
                    <span id="submit-loader" style="display:none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10" stroke-opacity=".25"/>
                            <path d="M12 2a10 10 0 0 1 10 10" style="animation:spin .8s linear infinite; transform-origin:center;">
                                <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur=".8s" repeatCount="indefinite"/>
                            </path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('contact-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form    = this;
    const btn     = document.getElementById('contact-submit');
    const icon    = document.getElementById('submit-icon');
    const text    = document.getElementById('submit-text');
    const loader  = document.getElementById('submit-loader');
    const alert   = document.getElementById('contact-alert');

    // Clear previous errors
    document.querySelectorAll('.field-error').forEach(el => { el.style.display='none'; el.textContent=''; });
    alert.style.display = 'none';

    // Show loader
    btn.disabled = true;
    icon.style.display  = 'none';
    loader.style.display = 'inline-flex';
    text.textContent = 'Sending…';

    try {
        const res = await fetch('{{ route("contact.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name:    form.name.value,
                email:   form.email.value,
                phone:   form.phone.value,
                subject: form.subject.value,
                message: form.message.value,
            }),
        });

        const data = await res.json();

        if (res.ok && data.success) {
            alert.style.cssText = 'display:block; background:#ecfdf5; color:#065f46; border:1px solid #6ee7b7;';
            alert.innerHTML = '<i class="fa fa-circle-check"></i> ' + data.message;
            form.reset();
        } else {
            // Validation errors
            if (data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const el = document.querySelector(`.field-error[data-field="${field}"]`);
                    if (el) { el.textContent = msgs[0]; el.style.display='block'; }
                });
            }
            alert.style.cssText = 'display:block; background:#fef2f2; color:#b91c1c; border:1px solid #fca5a5;';
            alert.innerHTML = '<i class="fa fa-circle-exclamation"></i> ' + (data.message || 'Please fix the errors above.');
        }
    } catch (err) {
        alert.style.cssText = 'display:block; background:#fef2f2; color:#b91c1c; border:1px solid #fca5a5;';
        alert.innerHTML = '<i class="fa fa-circle-exclamation"></i> Something went wrong. Please try again.';
    } finally {
        btn.disabled = false;
        icon.style.display    = '';
        loader.style.display  = 'none';
        text.textContent = 'Send Message';
        // Scroll to alert
        document.getElementById('contact-alert').scrollIntoView({ behavior:'smooth', block:'nearest' });
    }
});
</script>
@endpush
@endsection
