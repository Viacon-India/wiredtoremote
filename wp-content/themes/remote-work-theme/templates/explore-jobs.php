<?php
/**
 * Template Name: Explore Jobs
 */
get_header(); ?>

<!-- ============================================================
     FONTS & BASE RESET
============================================================ -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

<style>
/* ── CSS VARIABLES ──────────────────────────────────────────── */
:root {
  --bg:        #f5f3ee;
  --surface:   #ffffff;
  --ink:        #1a1a18;
  --ink-muted:  #6b6b65;
  --accent:     #d4501a;
  --accent-lt:  #fdeee7;
  --border:     #e2dfd8;
  --radius:     14px;
  --shadow:     0 2px 18px rgba(0,0,0,.07);
  --font-head:  'DM Serif Display', Georgia, serif;
  --font-body:  'DM Sans', sans-serif;
}

/* ── WRAPPER ────────────────────────────────────────────────── */
#jb-root {
  background: #f5f9fc;
  min-height: 100vh;
  font-family: var(--font-body);
  color: var(--ink);
  padding: 0 0 80px;
}

/* ── HERO ────────────────────────────────────────────────────── */
.jb-hero {
  background: #ddf5ff;
  color: #000;
  padding: 72px 24px 60px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.jb-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: repeating-linear-gradient(
    -45deg,
    transparent, transparent 40px,
    rgba(255,255,255,.025) 40px, rgba(255,255,255,.025) 41px
  );
}
.jb-hero h1 {
  font-family: var(--font-head);
  font-size: clamp(2rem, 5vw, 3.4rem);
  font-weight: 400;
  margin: 0 0 10px;
  position: relative;
  letter-spacing: -.01em;
  padding-top: 23px;
}
.jb-hero h1 em { color: #000080; font-style: italic; }
.jb-hero p {
  font-size: .95rem;
  opacity: .65;
  margin: 0 0 16px;
  position: relative;
}

/* ── SOURCE BADGES ───────────────────────────────────────────── */
.jb-sources {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 8px;
  position: relative;
  margin-top: 4px;
}
.jb-source-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: .72rem;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 20px;
  border: 1.5px solid rgba(0,0,128,.2);
  background: rgba(255,255,255,.6);
  color: #000080;
  letter-spacing: .04em;
  text-transform: uppercase;
  transition: opacity .3s, border-color .3s;
}
.jb-source-badge .dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
}
.jb-source-badge.loading .dot { animation: pulse-dot .9s infinite; }
.jb-source-badge.ok   { border-color: rgba(0,122,64,.4); color: #007a40; background: rgba(232,255,242,.7); }
.jb-source-badge.fail { border-color: rgba(200,0,0,.2); color: #999; opacity: .5; }
@keyframes pulse-dot {
  0%,100% { opacity: 1; }
  50%      { opacity: .25; }
}

/* ── CONTROLS BAR ────────────────────────────────────────────── */
.jb-controls {
  max-width: 1100px;
  margin: 36px auto 0;
  padding: 0 20px;
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
}
.jb-search-wrap {
  flex: 1 1 260px;
  position: relative;
}
.jb-search-wrap svg {
  position: absolute; left: 14px; top: 50%;
  transform: translateY(-50%);
  color: var(--ink-muted);
  pointer-events: none;
}
.jb-search {
  width: 100%;
  padding: 11px 14px 11px 42px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius);
  background: var(--surface);
  font-family: var(--font-body);
  font-size: .9rem;
  color: var(--ink);
  outline: none;
  transition: border-color .2s;
  box-sizing: border-box;
}
.jb-search:focus { border-color: #000080; }

.jb-select {
  padding: 11px 36px 11px 14px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius);
  background: var(--surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b6b65' stroke-width='1.8' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 12px center;
  -webkit-appearance: none;
  font-family: var(--font-body);
  font-size: .9rem;
  color: var(--ink);
  cursor: pointer;
  outline: none;
  transition: border-color .2s;
  min-width: 150px;
}
.jb-select:focus { border-color: #000080; }

.jb-count {
  margin-left: auto;
  font-size: .85rem;
  color: var(--ink-muted);
  white-space: nowrap;
}

/* ── SOURCE FILTER TABS ──────────────────────────────────────── */
.jb-source-tabs {
  max-width: 1100px;
  margin: 16px auto 0;
  padding: 0 20px;
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.jb-tab {
  padding: 6px 14px;
  border-radius: 20px;
  border: 1.5px solid var(--border);
  background: var(--surface);
  font-family: var(--font-body);
  font-size: .78rem;
  font-weight: 600;
  color: var(--ink-muted);
  cursor: pointer;
  transition: all .15s;
  letter-spacing: .02em;
}
.jb-tab:hover  { border-color: #000080; color: #000080; }
.jb-tab.active { background: #000080; border-color: #000080; color: #fff; }

/* ── SOURCE PILLS ON CARDS ───────────────────────────────────── */
.jb-source-pill {
  font-size: .7rem;
  font-weight: 600;
  padding: 2px 8px;
  border-radius: 20px;
  letter-spacing: .05em;
  text-transform: uppercase;
  white-space: nowrap;
}
.jb-source-pill.remotive  { background: #fff0e8; color: #c94b10; border: 1px solid #f9c9b0; }
.jb-source-pill.himalayas { background: #e8f4ff; color: #0057b8; border: 1px solid #b0d4f9; }
.jb-source-pill.remoteok  { background: #e8fff2; color: #007a40; border: 1px solid #9fe5c0; }

/* ── GRID ────────────────────────────────────────────────────── */
.jb-grid {
  max-width: 1100px;
  margin: 28px auto 0;
  padding: 0 20px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
}

/* ── CARD ────────────────────────────────────────────────────── */
.jb-card {
  background: var(--surface);
  border: 1.5px solid var(--border);
  border-radius: var(--radius);
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  box-shadow: var(--shadow);
  transition: transform .18s, box-shadow .18s, border-color .18s;
  text-decoration: none;
  color: inherit;
  cursor: pointer;
  animation: fadeUp .35s ease both;
}
.jb-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 32px rgba(0,0,0,.11);
  border-color: #000080;
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

.jb-card-top { display: flex; gap: 14px; align-items: flex-start; }

.jb-logo {
  width: 48px; height: 48px;
  border-radius: 10px;
  border: 1.5px solid var(--border);
  object-fit: contain;
  background: var(--bg);
  flex-shrink: 0;
}
.jb-logo-placeholder {
  width: 48px; height: 48px;
  border-radius: 10px;
  border: 1.5px solid var(--border);
  background: #cecef9;
  display: flex; align-items: center; justify-content: center;
  font-weight: 600;
  font-size: 1.1rem;
  color: #000080;
  flex-shrink: 0;
}
.jb-card-meta { flex: 1; min-width: 0; }
.jb-company {
  font-size: .78rem;
  font-weight: 500;
  color: var(--ink-muted);
  text-transform: uppercase;
  letter-spacing: .06em;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.jb-title {
  font-family: var(--font-head);
  font-size: 1.08rem;
  font-weight: 400;
  line-height: 1.3;
  margin: 4px 0 0;
  color: var(--ink);
}

.jb-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  align-items: center;
}
.jb-tag {
  font-size: .75rem;
  font-weight: 500;
  padding: 3px 10px;
  border-radius: 20px;
  background: var(--bg);
  color: var(--ink-muted);
  border: 1px solid var(--border);
  white-space: nowrap;
}
.jb-tag.accent { background: #cecef9; color: #000080; border-color: transparent; }

.jb-salary {
  font-size: .75rem;
  font-weight: 600;
  color: #007a40;
  background: #e8fff2;
  border: 1px solid #9fe5c0;
  padding: 3px 10px;
  border-radius: 20px;
  white-space: nowrap;
}

.jb-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
  padding-top: 14px;
  border-top: 1px solid var(--border);
}
.jb-date { font-size: .78rem; color: var(--ink-muted); }
.jb-apply {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: .82rem; font-weight: 600;
  color: #000080;
  text-decoration: none;
  padding: 6px 14px;
  border-radius: 8px;
  border: 1.5px solid #000080;
  transition: background .15s, color .15s;
}
.jb-apply:hover { background: #000080; color: #fff; }

/* ── LOAD MORE ───────────────────────────────────────────────── */
.jb-load-more-wrap { text-align: center; margin-top: 40px; }
.jb-btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 32px;
  background: #000;
  color: #fff;
  border: none; border-radius: var(--radius);
  font-family: var(--font-body);
  font-size: .92rem; font-weight: 600;
  cursor: pointer;
  transition: background .18s;
}
.jb-btn:hover    { background: #000080; }
.jb-btn:disabled { opacity: .5; cursor: not-allowed; }

/* ── SKELETON ────────────────────────────────────────────────── */
.jb-skeleton {
  background: var(--surface);
  border: 1.5px solid var(--border);
  border-radius: var(--radius);
  padding: 24px;
  display: flex; flex-direction: column; gap: 14px;
  box-shadow: var(--shadow);
}
.sk {
  background: linear-gradient(90deg, var(--bg) 25%, #e8e5de 50%, var(--bg) 75%);
  background-size: 200% 100%;
  border-radius: 6px;
  animation: shimmer 1.4s infinite;
}
@keyframes shimmer { to { background-position: -200% 0; } }

/* ── EMPTY ───────────────────────────────────────────────────── */
.jb-empty {
  grid-column: 1/-1;
  text-align: center;
  padding: 60px 20px;
  color: var(--ink-muted);
}
.jb-empty svg { opacity: .3; margin-bottom: 16px; }
.jb-empty p   { font-size: 1rem; margin: 0; }

/* ── RESPONSIVE ──────────────────────────────────────────────── */
@media(max-width: 600px) {
  .jb-hero     { padding: 48px 16px 40px; }
  .jb-controls { gap: 8px; }
  .jb-grid     { grid-template-columns: 1fr; padding: 0 12px; }
}
</style>

<div id="jb-root">

  <div class="jb-hero">
    <h1>Explore Your Next <em><span class="txt-rotate font-bold" data-period="2000" data-rotate='["Remote","Flexible","Global"]'></span></em>. Opportunity</h1>
    <p>Find freedom, flexibility, and top remote opportunities — all in one place.</p>
    <!--<div class="jb-sources">-->
      <!--<span class="jb-source-badge loading" id="src-remotive" ><span class="dot"></span>Remotive</span>-->
      <!--<span class="jb-source-badge loading" id="src-himalayas"><span class="dot"></span>Himalayas</span>-->
      <!--<span class="jb-source-badge loading" id="src-remoteok" ><span class="dot"></span>Remote OK</span>-->
    <!--</div>-->
  </div>

  <div class="jb-controls">
    <div class="jb-search-wrap">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
      </svg>
      <input class="jb-search" type="text" id="jb-search" placeholder="Search jobs, companies…">
    </div>

    <select class="jb-select" id="jb-category">
      <option value="">All Categories</option>
      <option value="software-dev">Software Dev</option>
      <option value="design">Design</option>
      <option value="marketing">Marketing</option>
      <option value="customer-support">Customer Support</option>
      <option value="data">Data</option>
      <option value="product">Product</option>
      <option value="devops-sysadmin">DevOps / SysAdmin</option>
      <option value="finance-legal">Finance / Legal</option>
      <option value="hr">HR</option>
      <option value="writing">Writing</option>
    </select>

    <select class="jb-select" id="jb-type">
      <option value="">All Types</option>
      <option value="full_time">Full-time</option>
      <option value="contract">Contract</option>
      <option value="part_time">Part-time</option>
    </select>

    <span class="jb-count" id="jb-count"></span>
  </div>

  <div class="jb-source-tabs">
    <!--<button class="jb-tab active" data-source="">All Sources</button>-->
    <!--<button class="jb-tab" data-source="remotive">Remotive</button>-->
    <!--<button class="jb-tab" data-source="himalayas">Himalayas</button>-->
    <!--<button class="jb-tab" data-source="remoteok">Remote OK</button>-->
  </div>

  <div class="jb-grid" id="jb-grid"></div>

  <div class="jb-load-more-wrap" id="jb-more-wrap" style="display:none">
    <button class="jb-btn" id="jb-more-btn">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M19 9l-7 7-7-7"/>
      </svg>
      Load more jobs
    </button>
  </div>
</div>

<script>
(function () {

  /* ════════════════════════════════════════════════
     CONFIG  — adjust AJAX_URL if needed
  ════════════════════════════════════════════════ */
  // WordPress localises ajaxurl automatically on admin pages,
  // but on front-end templates we define it here via PHP:
  const AJAX_URL = '<?php echo esc_js(admin_url("admin-ajax.php")); ?>';

  const SOURCES = {
    remotive:  { label: 'Remotive',  direct: 'https://remotive.com/api/remote-jobs?limit=100' },
    himalayas: { label: 'Himalayas', pages: ['himalayas_0','himalayas_1','himalayas_2'] },
    remoteok:  { label: 'Remote OK', proxy: 'remoteok' },
    
  };

  const PAGE_SIZE = 12;

  /* ── STATE ─────────────────────────────────────────── */
  let allJobs      = [];
  let filtered     = [];
  let page         = 1;
  let activeSource = '';

  /* ── ELEMENTS ──────────────────────────────────────── */
  const grid     = document.getElementById('jb-grid');
  const searchEl = document.getElementById('jb-search');
  const catEl    = document.getElementById('jb-category');
  const typeEl   = document.getElementById('jb-type');
  const countEl  = document.getElementById('jb-count');
  const moreWrap = document.getElementById('jb-more-wrap');
  const moreBtn  = document.getElementById('jb-more-btn');

  /* ── HELPERS ───────────────────────────────────────── */
  function timeAgo(dateStr) {
    if (!dateStr) return '';
    const diff = Date.now() - new Date(dateStr).getTime();
    const d = Math.floor(diff / 86400000);
    if (isNaN(d) || d < 0) return '';
    if (d === 0) return 'Today';
    if (d === 1) return 'Yesterday';
    if (d < 30)  return d + ' days ago';
    if (d < 365) return Math.floor(d / 30) + ' mo ago';
    return Math.floor(d / 365) + ' yr ago';
  }

  function initials(name) {
    return (name || '?').split(/\s+/).slice(0,2).map(w => w[0]).join('').toUpperCase();
  }

  function sanitize(str) {
    const d = document.createElement('div');
    d.textContent = String(str || '');
    return d.innerHTML;
  }

  function slugify(str) {
    return (str || '').toLowerCase().replace(/\s+&\s+|\s+/g,'-').replace(/[^a-z0-9-]/g,'');
  }

  function formatSalary(min, max, currency) {
    if (!min && !max) return null;
    const fmt = n => n >= 1000 ? Math.round(n/1000)+'k' : n;
    const cur = currency || 'USD';
    if (min && max) return `${cur} ${fmt(min)}–${fmt(max)}`;
    if (min)        return `${cur} ${fmt(min)}+`;
    return null;
  }

  /* ── SOURCE BADGE ──────────────────────────────────── */
  function setBadge(key, state) { // state: 'ok' | 'fail'
    const el = document.getElementById('src-' + key);
    if (!el) return;
    el.classList.remove('loading');
    el.classList.add(state);
  }

  /* ── NORMALISERS ───────────────────────────────────── */
  function normRemotive(jobs) {
    return (jobs||[]).map(j => ({
      _source: 'remotive', _id: 'r_'+j.id,
      title: j.title||'', company_name: j.company_name||'',
      company_logo: j.company_logo_url||'', url: j.url||'#',
      job_type: j.job_type||'', salary: null,
      category: j.category||'', category_slug: slugify(j.category),
      date: j.publication_date||'',
    }));
  }

  function normHimalayas(jobs) {
    const typeMap = {'Full-time':'full_time','Part-time':'part_time','Contract':'contract','Temporary':'contract','Freelance':'contract'};
    return (jobs||[]).map(j => ({
      _source: 'himalayas', _id: 'h_'+(j.slug||j.title+j.companyName),
      title: j.title||'', company_name: j.companyName||'',
      company_logo: j.companyLogo||'',
      url: j.applicationLink||j.applyUrl||j.url||'#',
      job_type: typeMap[j.employmentType] || (j.employmentType||'').toLowerCase().replace(/\s+/g,'_'),
      salary: formatSalary(j.minSalary, j.maxSalary, j.currency),
      category: j.categories&&j.categories[0] ? j.categories[0].replace(/-/g,' ') : '',
      category_slug: j.categories&&j.categories[0] ? j.categories[0].toLowerCase() : '',
      date: j.updatedAt ? new Date(j.updatedAt*1000).toISOString() : '',
    }));
  }

  function normRemoteOK(raw) {
    // RemoteOK returns a plain JSON array.
    // Index 0 is always a legal/meta object (no `id` field or has `legal` key) — skip it.
    // Each job has: id, slug, epoch, date (unix ts), company, company_logo,
    //               position, tags (array), url, salary (string or null)
    if (!Array.isArray(raw)) {
      console.warn('[RemoteOK] Unexpected response type:', typeof raw, raw);
      return [];
    }
    const jobs = raw.filter(j => j && j.id && j.position); // skip meta row
    console.log('[RemoteOK] Raw jobs count:', jobs.length, jobs[0] || '(empty)');
    return jobs.map(j => ({
      _source: 'remoteok', _id: 'o_'+j.id,
      title:        j.position   || '',
      company_name: j.company    || '',
      company_logo: j.company_logo || '',
      url:          j.url        || '#',
      job_type:     'full_time',
      salary:       (j.salary && j.salary !== 'No salary listed') ? j.salary : null,
      category:     Array.isArray(j.tags) && j.tags[0] ? j.tags[0] : '',
      category_slug:Array.isArray(j.tags) && j.tags[0]
                      ? j.tags[0].toLowerCase().replace(/[^a-z0-9]/g,'-') : '',
      // `date` field is a Unix timestamp (seconds)
      date:         j.date ? new Date(j.date * 1000).toISOString() : '',
    }));
  }

  /* ── DEDUP ─────────────────────────────────────────── */
  function dedup(jobs) {
    const seen = new Set();
    return jobs.filter(j => {
      const key = (j.title+'|'+j.company_name).toLowerCase().replace(/\s/g,'');
      if (seen.has(key)) return false;
      seen.add(key); return true;
    });
  }

  /* ── PROXY FETCH (Himalayas / RemoteOK) ────────────── */
  function proxyFetch(src) {
    return fetch(`${AJAX_URL}?action=jb_proxy&src=${encodeURIComponent(src)}`)
      .then(r => {
        if (!r.ok) throw new Error('Proxy HTTP ' + r.status);
        return r.json();
      })
      .then(d => {
        // wp_send_json_error returns {success:false, data:{...}} — surface the error
        if (d && d.success === false) {
          console.warn('[jb_proxy] src=' + src, d.data);
          throw new Error('Proxy error for ' + src);
        }
        return d;
      });
  }

  /* ── SKELETON ──────────────────────────────────────── */
  function showSkeletons(n=6) {
    grid.innerHTML = Array(n).fill(0).map(()=>`
      <div class="jb-skeleton">
        <div style="display:flex;gap:12px;align-items:flex-start">
          <div class="sk" style="width:48px;height:48px;border-radius:10px;flex-shrink:0"></div>
          <div style="flex:1">
            <div class="sk" style="height:11px;width:40%;margin-bottom:8px"></div>
            <div class="sk" style="height:16px;width:85%"></div>
          </div>
        </div>
        <div style="display:flex;gap:6px">
          <div class="sk" style="height:22px;width:70px;border-radius:20px"></div>
          <div class="sk" style="height:22px;width:90px;border-radius:20px"></div>
        </div>
        <div class="sk" style="height:1px;margin:4px 0"></div>
        <div style="display:flex;justify-content:space-between">
          <div class="sk" style="height:11px;width:30%"></div>
          <div class="sk" style="height:28px;width:80px;border-radius:8px"></div>
        </div>
      </div>`).join('');
  }

  /* ── RENDER CARD ───────────────────────────────────── */
  function renderCard(job) {
    const logoHtml = job.company_logo
      ? `<img class="jb-logo" src="${sanitize(job.company_logo)}" alt="${sanitize(job.company_name)}" loading="lazy" onerror="this.replaceWith(window.makePlaceholder('${initials(job.company_name)}'))">`
      : `<div class="jb-logo-placeholder">${initials(job.company_name)}</div>`;

    const typeLabel = {full_time:'Full-time',part_time:'Part-time',contract:'Contract'}[job.job_type]||job.job_type;
    const tags = [
      typeLabel ? {text:typeLabel,accent:false} : null,
      job.category ? {text:job.category,accent:false} : null,
      {text:'Remote',accent:true},
    ].filter(Boolean).slice(0,3);

    const tagsHtml  = tags.map(t=>`<span class="jb-tag${t.accent?' accent':''}">${sanitize(t.text)}</span>`).join('');
    const salaryHtml = job.salary ? `<span class="jb-salary">${sanitize(job.salary)}</span>` : '';
    const srcPill    = `<span class="jb-source-pill ${job._source}">${SOURCES[job._source]?.label||job._source}</span>`;

    const card = document.createElement('a');
    card.className     = 'jb-card';
    card.href          = job.url;
    card.target        = '_blank';
    card.rel           = 'noopener noreferrer';
    card.dataset.source = job._source;
    card.innerHTML = `
      <div class="jb-card-top">
        ${logoHtml}
        <div class="jb-card-meta">
          <div class="jb-company">${sanitize(job.company_name)}</div>
          <div class="jb-title">${sanitize(job.title)}</div>
        </div>
      </div>
      <div class="jb-tags">${tagsHtml}${salaryHtml}${srcPill}</div>
      <div class="jb-footer">
        <span class="jb-date">${timeAgo(job.date)}</span>
        <span class="jb-apply">Apply →</span>
      </div>`;
    return card;
  }

  /* ── RENDER PAGE ───────────────────────────────────── */
  function renderPage(reset=false) {
    if (reset) { page=1; grid.innerHTML=''; }
    const slice    = filtered.slice(0, page*PAGE_SIZE);
    const existing = grid.querySelectorAll('.jb-card').length;
    const frag     = document.createDocumentFragment();

    slice.slice(existing).forEach((job,i)=>{
      const card = renderCard(job);
      card.style.animationDelay = (i*40)+'ms';
      frag.appendChild(card);
    });

    if (!filtered.length) {
      grid.innerHTML = `
        <div class="jb-empty">
          <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p>No jobs found. Try different filters.</p>
        </div>`;
    } else {
      grid.appendChild(frag);
    }

    countEl.textContent = `${filtered.length.toLocaleString()} job${filtered.length!==1?'s':''}`;
    moreWrap.style.display = slice.length < filtered.length ? 'block' : 'none';
  }

  /* ── FILTER ────────────────────────────────────────── */
  function applyFilters() {
    const q    = searchEl.value.trim().toLowerCase();
    const cat  = catEl.value;
    const type = typeEl.value;

    filtered = allJobs.filter(job => {
      if (activeSource && job._source !== activeSource) return false;
      if (q && !job.title.toLowerCase().includes(q) && !job.company_name.toLowerCase().includes(q)) return false;
      if (cat  && job.category_slug !== cat) return false;
      if (type && job.job_type !== type)     return false;
      return true;
    });
    renderPage(true);
  }

  /* ── PROGRESSIVE LOAD: render as each source arrives ── */
  function mergeAndRender(newJobs) {
    allJobs = dedup([...allJobs, ...newJobs].sort((a,b)=> new Date(b.date)-new Date(a.date)));
    applyFilters();
  }

  /* ── FETCH ALL ─────────────────────────────────────── */
  async function fetchAll() {
    showSkeletons(PAGE_SIZE);

    // ① Remotive — direct (has CORS headers)
    fetch(SOURCES.remotive.direct)
      .then(r => r.json())
      .then(d => { setBadge('remotive','ok'); mergeAndRender(normRemotive(d.jobs)); })
      .catch(()  => setBadge('remotive','fail'));

    // ② Himalayas — via WP proxy (3 pages)
    Promise.all(SOURCES.himalayas.pages.map(src => proxyFetch(src)))
      .then(pages => {
        setBadge('himalayas','ok');
        mergeAndRender(normHimalayas(pages.flatMap(p => p.jobs || [])));
      })
      .catch(()  => setBadge('himalayas','fail'));

    // ③ RemoteOK — via WP proxy
    proxyFetch(SOURCES.remoteok.proxy)
      .then(d => { setBadge('remoteok','ok'); mergeAndRender(normRemoteOK(d)); })
      .catch(()  => setBadge('remoteok','fail'));
  }

  /* ── LOGO PLACEHOLDER (runtime) ────────────────────── */
  window.makePlaceholder = function(letters) {
    const el = document.createElement('div');
    el.className  = 'jb-logo-placeholder';
    el.textContent = letters;
    return el;
  };

  /* ── EVENTS ────────────────────────────────────────── */
  let debounceTimer;
  searchEl.addEventListener('input', ()=>{ clearTimeout(debounceTimer); debounceTimer=setTimeout(applyFilters,280); });
  catEl.addEventListener('change', applyFilters);
  typeEl.addEventListener('change', applyFilters);
  moreBtn.addEventListener('click', ()=>{ page++; renderPage(false); });

  document.querySelectorAll('.jb-tab').forEach(tab => {
    tab.addEventListener('click', ()=>{
      document.querySelectorAll('.jb-tab').forEach(t=>t.classList.remove('active'));
      tab.classList.add('active');
      activeSource = tab.dataset.source;
      applyFilters();
    });
  });

  /* ── INIT ──────────────────────────────────────────── */
  fetchAll();
})();
</script>

<?php get_footer(); ?>