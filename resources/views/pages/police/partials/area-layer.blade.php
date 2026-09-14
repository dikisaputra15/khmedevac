@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>

#police-area-layer-content {
  --navy:#173f69;
  --ink:#111;
  --line:#cfcfcf;
  --paper:#fff;
  --page-bg:#e9edf2;
}
#police-area-layer-content * { box-sizing:border-box; }
#police-area-layer-content { background:var(--page-bg); }
#police-area-layer-content {
  margin:0;
  padding:22px;
  font-family:'Karla', Arial, Helvetica, sans-serif;
  color:var(--ink);
  background:var(--page-bg);
}
#police-area-layer-content .page {
  width:min(1600px, 100%);
  margin:0 auto;
  background:var(--paper);
  box-shadow:0 10px 34px rgba(0,0,0,.16);
  padding:16px 28px 18px;
}
#police-area-layer-content .topbar {
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:24px;
  margin-bottom:12px;
}
#police-area-layer-content .brand { display:flex; align-items:center; gap:14px; min-width:0; }
#police-area-layer-content .cnp-logo { width:78px; height:78px; object-fit:contain; flex:none; }
#police-area-layer-content .titles { padding-top:1px; min-width:0; }
#police-area-layer-content h1 {
  margin:0;
  color:var(--navy);
  font-size:clamp(25px, 2.25vw, 36px);
  line-height:1.04;
  letter-spacing:.2px;
  font-weight:800;
}
#police-area-layer-content .subtitle {
  margin-top:3px;
  color:var(--navy);
  font-size:clamp(17px, 1.45vw, 23px);
  line-height:1.12;
  font-weight:700;
}
#police-area-layer-content .concord-logo { width:200px; height:auto; margin-top:5px; flex:none; }
#police-area-layer-content .police-table {
  width:100%;
  border-collapse:collapse;
  table-layout:fixed;
  font-size:14px;
}
#police-area-layer-content .police-table col:nth-child(1) { width:22.35%; }
#police-area-layer-content .police-table col:nth-child(2) { width:19.10%; }
#police-area-layer-content .police-table col:nth-child(3) { width:21.05%; }
#police-area-layer-content .police-table col:nth-child(4) { width:37.50%; }
#police-area-layer-content .police-table thead th {
  font-size:14px;
  font-weight:800;
  text-align:center;
  padding:9px 8px 10px;
  border-bottom:2px solid #111;
}
#police-area-layer-content .police-table tbody tr { border-bottom:1px solid var(--line); }
#police-area-layer-content .police-table tbody tr:last-child { border-bottom:0; }
#police-area-layer-content .police-table td {
  vertical-align:middle;
  padding:10px 14px;
  border-right:1px solid var(--line);
  line-height:1.24;
}
#police-area-layer-content .police-table td:last-child { border-right:0; }
#police-area-layer-content .layer { text-align:center; color:var(--navy); font-weight:800; font-size:14px; }
#police-area-layer-content .admin { text-align:center; font-weight:700; font-size:14px; }
#police-area-layer-content .rank-cell { padding-left:18px !important; padding-right:12px !important; }
#police-area-layer-content .rank-stack { display:flex; flex-direction:column; gap:7px; }
#police-area-layer-content .rank {
  display:grid;
  grid-template-columns:52px 1fr;
  align-items:center;
  gap:8px;
  min-height:25px;
  font-weight:800;
  font-size:14px;
  line-height:1.08;
}
#police-area-layer-content .rank-insignia-wrap { position:relative; width:52px; height:24px; display:block; overflow:visible; }
#police-area-layer-content .rank-insignia {
  position:absolute;
  left:50%;
  top:50%;
  width:23px;
  height:50px;
  object-fit:contain;
  transform:translate(-50%,-50%) rotate(-90deg);
  transform-origin:center;
}
#police-area-layer-content .role { vertical-align:top !important; padding-top:8px !important; padding-bottom:8px !important; }
#police-area-layer-content .role ul { margin:0; padding-left:20px; }
#police-area-layer-content .role li { margin:0 0 2px 0; }
#police-area-layer-content .role li:last-child { margin-bottom:0; }
#police-area-layer-content .note {
  margin-top:8px;
  color:var(--navy);
  font-size:13px;
  line-height:1.25;
  font-weight:500;
}
#police-area-layer-content .note strong { font-weight:800; }
@media (max-width:1100px) {
#police-area-layer-content { padding:0; }
#police-area-layer-content .page { width:100%; box-shadow:none; padding:14px 16px 20px; overflow-x:auto; }
#police-area-layer-content .topbar, #police-area-layer-content .police-table, #police-area-layer-content .note { min-width:1080px; }
}

#policeAreaLayerModal .police-area-layer-dialog {
  width: calc(100% - 1rem);
  max-width: 1600px;
  margin-left: auto;
  margin-right: auto;
}
#police-area-layer-content .page { box-shadow: none; }
#police-area-layer-content .topbar,
#police-area-layer-content .police-table,
#police-area-layer-content .note { min-width: 1080px; }
#police-area-layer-content .page { overflow-x: auto; }
</style>
@endpush

<div id="police-area-layer-content">
<main class="page">
  <header class="topbar">
    <div class="brand">
      <img alt="Cambodian National Police emblem" class="cnp-logo" src="{{ asset('images/police-area-layer/image-1.jpeg') }}"/>
      <div class="titles">
        <h1>CAMBODIAN NATIONAL POLICE (CNP)</h1>
        <div class="subtitle">Police Territorial Areas and Administrative Equivalents</div>
      </div>
    </div>
    <img alt="Concord Consulting" class="concord-logo" src="{{ asset('images/police-area-layer/image-2.png') }}"/>
  </header>
  <table class="police-table">
    <colgroup><col/><col/><col/><col/></colgroup>
    <thead>
      <tr>
        <th>POLICE LAYER</th>
        <th>ADMINISTRATIVE EQUIVALENT</th>
        <th>TYPICAL SENIOR RANK</th>
        <th>DOCTRINAL ROLE</th>
      </tr>
    </thead>
    <tbody>
      <tr>
  <td class="layer">Commissioner-General of the Cambodian National Police (CNP)</td>
  <td class="admin">National Level</td>
  <td class="rank-cell"><div class="rank-stack"><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police General rank insignia" src="{{ asset('images/police-area-layer/rank-1.gif') }}"/></span><span>Police General</span></div></div></td>
  <td class="role"><ul><li>Direct and supervise all national, specialized, and territorial police forces.</li><li>Manage personnel appointments, promotions, discipline across the CNP.</li><li>Represent the CNP before the Royal Government and international organizations.</li><li>Advise the Minister of Interior on policing, public security, and internal security.</li></ul></td>
</tr><tr>
  <td class="layer">Provincial / Municipal Police Commissariat</td>
  <td class="admin">Provincial<br/>Capital</td>
  <td class="rank-cell"><div class="rank-stack"><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police Major General rank insignia" src="{{ asset('images/police-area-layer/rank-2.gif') }}"/></span><span>Police Major General</span></div><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police Brigadier General rank insignia" src="{{ asset('images/police-area-layer/rank-3.gif') }}"/></span><span>Police Brigadier General</span></div></div></td>
  <td class="role"><ul><li>Command and supervise all district police inspectorates.</li><li>Implement national policing policies and operational directives.</li><li>Coordinate crime prevention, criminal investigations, and public order operations.</li><li>Manage emergency response and disaster-related policing activities.</li></ul></td>
</tr><tr>
  <td class="layer">District Police Inspectorate</td>
  <td class="admin">District<br/>Municipality<br/>Khan</td>
  <td class="rank-cell"><div class="rank-stack"><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police Lieutenant Colonel rank insignia" src="{{ asset('images/police-area-layer/rank-4.gif') }}"/></span><span>Police Lieutenant Colonel</span></div><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police Colonel rank insignia" src="{{ asset('images/police-area-layer/rank-5.gif') }}"/></span><span>Police Colonel</span></div></div></td>
  <td class="role"><ul><li>Supervise commune police posts.</li><li>Conduct district-level law enforcement and crime prevention operations.</li><li>Coordinate criminal investigations within the district.</li><li>Maintain public order during local events and emergencies.</li></ul></td>
</tr><tr>
  <td class="layer">Commune Police Post</td>
  <td class="admin">Commune<br/>Sangkat</td>
  <td class="rank-cell"><div class="rank-stack"><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police Major rank insignia" src="{{ asset('images/police-area-layer/rank-6.gif') }}"/></span><span>Police Major</span></div><div class="rank"><span class="rank-insignia-wrap"><img class="rank-insignia" alt="Police Captain rank insignia" src="{{ asset('images/police-area-layer/rank-7.gif') }}"/></span><span>Police Captain</span></div></div></td>
  <td class="role"><ul><li>Conduct routine patrols and visible police presence.</li><li>Respond to emergencies, crimes, and public complaints.</li><li>Prevent and detect criminal activities.</li><li>Receive and process initial reports of criminal and public order incidents.</li></ul></td>
</tr>
    </tbody>
  </table>
  <div class="note"><strong>Note:</strong> Administrative terminology varies by jurisdiction. Phnom Penh Capital uses Khan → Sangkat, while Provinces use District/Municipality → Commune/Sangkat. Khan, District, and Municipality are equivalent administrative levels; Commune and Sangkat are equivalent lower-level units.</div>
</main>
</div>