@extends('layouts.master')

@section('title', 'Dashboard')

@section('page-title', 'Cambodia Crisis Management Tools')

@push('styles')


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #map {
            height: 700px;
        }
        .filter-container {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        /* === Facilities filter list (map panel) === */
        .facility-list {
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .facility-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 1px 6px;
            border-radius: 5px;
            transition: background-color .15s ease;
        }
        .facility-item:hover { background-color: #f4f7fb; }
        .facility-item .form-check-input {
            position: static;
            float: none;
            flex: 0 0 15px;
            width: 15px;
            height: 15px;
            margin: 0;
            cursor: pointer;
        }
        .facility-item .form-check-label {
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 0;
            font-size: 13px;
            line-height: 18px;
            color: #333;
            cursor: pointer;
        }
        .facility-item .facility-name.is-all { font-weight: 600; }
        .facility-item .facility-count {
            flex: 0 0 auto;
            min-width: 26px;
            padding: 0 7px;
            border-radius: 10px;
            background: #edf1f5;
            color: #4f5963;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
        }
        .facility-item .form-check-input:checked + .form-check-label .facility-count {
            background: #dceaff;
            color: #1769c2;
        }
        .form-check-scrollable {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }
        .total-info {
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0,0,0,0.2);
            font-weight: bold;
            margin-left: 10px;
        }

        .select2-container .select2-selection--single {
            height: 45px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
            right: 10px;
        }

        .p-modal{
            text-align:justify;
        }
        .hospital-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0 5px;
        }
        .hospital-legend-item img {
            width: 30px;
            height: 30px;
        }

        p{
        margin-bottom: 8px;
            line-height: 18px;
        }

        .btn-danger{
            background-color:#395272;
            border-color: transparent;
        }

        .btn-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .btn.active {
            background-color: #5686c3 !important;
            border-color: transparent !important;
            color: #fff !important;
        }

        .p-3{
            padding: 10px !important;
            margin: 0 3px;
        }

        .btn-outline-danger{
            color: #FFFFFF;
            background-color:#395272;
            border-color: transparent;
        }

        .btn-outline-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .fa,
        .fab,
        .fad,
        .fal,
        .far,
        .fas {
            color: #346abb;
        }

        .card-header{
            padding: 0.25rem 1.25rem;
            color: #3c66b5;
            font-weight: bold;
        }

        .mb-4{
            margin-bottom: 0.5rem !important;
        }

    /* Classification section */
    .classification {
      display: flex;
      width: 100%;
    }

    .class-column {
      flex: 1;
      text-align: left;

    }
    .class-column:last-child {
      border-right: none;
    }

    .class-header {
      font-weight: 600;
      padding: 0.1rem 0;
      text-align: left;
    }

    /* Color bars */
    .class-medical-classification {border: none; text-align: left; text-transform: uppercase;}
    .class-airport-category {border: none; text-transform: uppercase;}
    .class-advanced { border-bottom: 3px solid #0070c0; }
    .class-intermediate { border-bottom: 3px solid #00b050; }
    .class-basic { border-bottom: 3px solid #ffc000; }

    .dashboard-legend-bar {
      display: flex;
      align-items: flex-start;
      width: 100%;
    }

    .dashboard-legend-content {
      flex: 1 1 auto;
      min-width: 0;
    }

    .dashboard-legend-groups {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 24px;
    }

    .dashboard-navigation {
      flex: 0 0 auto;
      margin-left: auto;
    }

    @media (max-width: 1600px) {
      .dashboard-legend-bar {
        flex-wrap: wrap;
      }

      .dashboard-legend-content {
        flex-basis: 100%;
      }

      .dashboard-legend-groups {
        flex-wrap: wrap;
      }

      .dashboard-navigation {
        width: 100%;
      }
    }

    /* Airport layout */
    .airport-list {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 0 10px;
    }

    /* Hospital layout */
    .hospital-list {
      display: flex;
      flex-direction: column;
      align-items: flex-start;

    }

    /* For side-by-side classes */
    .hospital-row {
      display: flex;
      justify-content: flex-start;
      align-items: flex-start;
      gap: 0;
    }

    .hospital-item {
      display: flex;
      align-items: center;
      gap: 0;
      font-size: 0.9rem;
      white-space: nowrap;
    }

    .hospital-item .btn {
      text-align: left;
    }

    .hospital-icon {
      width: 18px;
      height: 18px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Image inside icon box */
    .hospital-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Airfield icons */
    .category-item img {
      width: 16px;
      height: 16px;
      object-fit: contain;
    }

     .select-input {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px 10px;
        background: #fff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .select-input input {
        border: none;
        width: 100%;
        cursor: pointer;
        background: transparent;
        outline: none;
    }

    .select-dropdown {
        display: none;
        position: absolute;
        width: 100%;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-top: 3px;
        z-index: 9999;
        max-height: 250px;
        overflow: hidden;
    }

    .select-dropdown.show {
        display: block;
    }

    .dropdown-search {
        width: 100%;
        border: none;
        border-bottom: 1px solid #ddd;
        padding: 8px;
        outline: none;
    }

    #provinceList {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 180px;
        overflow-y: auto;
    }

    #provinceList li {
        padding: 5px 10px;
    }

    #provinceList li:hover {
        background: #f5f5f5;
    }

    #provinceList label {
        width: 100%;
        margin: 0;
        cursor: pointer;
    }

    .legend-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    width: 100%;
    align-items: start;
}

.legend-grid-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 6px;
    width: 100%;
    text-align: left;
    white-space: nowrap;
}

.legend-grid-item img {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

.legend-grid-item small {
    text-align: left;
}

/* ===== Google Places Autocomplete Fix ===== */
.pac-container {
    z-index: 99999 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2) !important;
    font-family: inherit !important;
    margin-top: 2px !important;
    border: 1px solid #ddd !important;
}

.pac-item {
    padding: 6px 12px !important;
    cursor: pointer !important;
    font-size: 13px !important;
    border-top: 1px solid #f0f0f0 !important;
}

.pac-item:hover {
    background: #f0f6ff !important;
}

.pac-item-query {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #333 !important;
}

.pac-matched {
    color: #1a73e8 !important;
    font-weight: 700 !important;
}

#locationSearchMap:focus {
    outline: none !important;
    border-color: #1a73e8 !important;
    box-shadow: 0 0 0 2px rgba(26,115,232,0.2) !important;
}

/* ===== Medical Facility Modals ===== */
.medical-facility-modal .modal-dialog {
    width: calc(100% - 12px);
    max-width: 1200px;
}

.medical-facility-modal .nav-tabs .nav-link {
    padding: 10px 14px;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.2;
}

.medical-facility-modal .nav-tabs {
    gap: 4px;
}

@media (max-width: 575.98px) {
    .medical-facility-modal .modal-dialog {
        width: auto;
        margin: 6px;
    }

    .medical-facility-modal .nav-tabs .nav-link {
        padding: 9px 11px;
        font-size: 11px;
    }
}

</style>

@endpush

@section('conten')

<div class="card">
    <div class="dashboard-legend-bar" style="background-color: #dfeaf1;">
       <div class="dashboard-legend-content">
            <div class="d-flex p-3" style="justify-content: flex-start;">
                <div class="dashboard-legend-groups">

                <!-- Airport -->
                      <div>
                        <div class="class-header class-airport-category">AIRFIELD CLASSIFICATION</div>
                        <div class="airport-list">
                          <div style="display: grid; grid-template-columns: max-content max-content max-content max-content; column-gap: 15px; row-gap: 5px;">
                            <!-- Airport row 1 -->
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#level6Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:18px; height:18px;">
                                  <small>International</small>
                              </button>
                            </div>
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#level5Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:18px; height:18px;">
                                  <small>Domestic</small>
                              </button>
                            </div>
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#level4Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:18px; height:18px;">
                                  <small>Regional</small>
                              </button>
                            </div>
                            <div></div> <!-- empty grid item for row 1 -->

                            <!-- Airport row 2 -->
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#level2Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:18px; height:18px;">
                                  <small>Civil-Military</small>
                              </button>
                            </div>
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#level3Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:18px; height:18px;">
                                  <small>Military</small>
                              </button>
                            </div>
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                  <small>Private</small>
                              </button>
                            </div>
                            <div class="hospital-item">
                              <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/11/helipad-removebg.png" style="width:18px; height:18px;">
                                  <small>Helipad</small>
                              </button>
                            </div>
                          </div>

                        </div>
                      </div>

                      <!-- Medical Facility Legend -->
                      <div style="flex-direction: column;">
                        <!-- Title -->
                        <div>
                            <div class="class-header class-medical-classification">MEDICAL FACILITY CLASSIFICATION</div>
                        </div>
                        <div style="display: flex; flex-direction: row;">
                            <!-- Advanced -->
                            <div class="class-column">
                              <div class="class-header class-advanced">&nbsp</div>
                              <div class="hospital-list">
                                <div class="hospital-item">
                                  <button class="btn p-1">
                                    <small>Public</small>
                                  </button>
                                </div>
                                <div class="hospital-item">
                                    <button class="btn p-1">
                                      <small>Private</small>
                                    </button>
                                  </div>
                              </div>
                            </div>

                             <!-- Advanced -->
                            <div class="class-column">
                              <div class="class-header class-advanced">Advanced</div>
                              <div class="hospital-list">
                                <div class="hospital-item">
                                  <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                                    <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                                    <small>National (CPA3+)</small>
                                  </button>
                                </div>
                                <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                                      <small>Large Hospital</small>
                                    </button>
                                  </div>
                              </div>
                            </div>

                            <!-- Intermediate -->
                            <div class="class-column">
                              <div class="class-header class-intermediate">Intermediate</div>
                              <div class="hospital-list">
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level44Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:24px; height:24px;">
                                      <small>Provincial (CPA3) / District (CPA2)</small>
                                    </button>
                                  </div>
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                                      <small>Medium Hospital / Polyclinic</small>
                                    </button>
                                  </div>
                              </div>
                            </div>

                            <!-- Basic -->
                            <div class="class-column">
                              <div class="class-header class-basic">Basic</div>
                              <div class="hospital-list">
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level22Modal">
                                        <img src="https://id.concordreview.com/wp-content/uploads/2026/02/hospital_pin-orange.png" style="width:24px; height:24px;">
                                        <small>District (CPA1) / Health Center (MPA)</small>
                                    </button>
                                  </div>
                                   <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level11Modal">
                                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:24px; height:24px;">
                                        <small>Small Hospital</small>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div>
                        <div class="class-header class-airport-category">POLICE CLASSIFICATION</div>

                        <div class="airport-list">
                            <div style="display: grid; grid-template-columns: max-content max-content; column-gap: 15px; row-gap: 5px;">
                                <div class="hospital-item">
                                    <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#police1Modal">
                                        <img src="{{ asset('images/Layer1.png') }}" style="width:12px; height:12px;">
                                        <small>National Police (HQ)</small>
                                    </button>
                                </div>
                                <div class="hospital-item">
                                    <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#police2Modal">
                                        <img src="{{ asset('images/Layer2.png') }}" style="width:12px; height:12px;">
                                        <small>Provincial Police</small>
                                    </button>
                                </div>
                                <div class="hospital-item">
                                    <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#police3Modal">
                                         <img src="{{ asset('images/Layer3.png') }}" style="width:12px; height:12px;">
                                        <small>District Police</small>
                                    </button>
                                </div>
                                <div class="hospital-item">
                                    <button class="btn p-1 text-start w-100" data-bs-toggle="modal" data-bs-target="#police4Modal">
                                        <img src="{{ asset('images/Layer4.png') }}" style="width:12px; height:12px;">
                                        <small>Commune Police Post</small>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-navigation">
            <div class="d-flex justify-content-end p-3">
                <div class="d-flex gap-2 mt-2">

                    <a href="{{ url('home') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill fs-3"></i>
                        <small>Home</small>
                    </a>

                    <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                        <i class="bi bi-airplane fs-3"></i>
                        <small>Aviation</small>
                    </a>

                    <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                        <small>Medical</small>
                    </a>

                    <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                    <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                        <small>Police</small>
                    </a>

                    <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                        <small>Embassies</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <button class="btn btn-link p-0 fw-bold text-decoration-underline text-dark" data-bs-toggle="modal" data-bs-target="#disclaimerModal">
            <i class="bi bi-info-circle text-primary fs-5"></i>
            <small>Disclaimer</small>
        </button>
    </div>

</div>

<div style="position:relative;">

<div id="map"></div>

<!-- Route Detail Panel -->
<div id="routePanel" style="
    display:none;
    position:absolute;
    top:10px;
    left:10px;
    width:300px;
    max-height:calc(100% - 20px);
    background:#fff;
    border-radius:10px;
    box-shadow:0 4px 20px rgba(0,0,0,0.18);
    z-index:999;
    display:none;
    flex-direction:column;
    overflow:hidden;
    font-family:inherit;
">
    <!-- Header -->
    <div style="background:#1a73e8;padding:12px 14px;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;">
        <div>
            <div style="font-size:11px;opacity:0.85;letter-spacing:0.5px;">DRIVING DIRECTIONS</div>
            <div id="routePanelTitle" style="font-size:13px;font-weight:600;margin-top:2px;">—</div>
        </div>
        <button onclick="closeRoutePanel()" style="background:rgba(255,255,255,0.2);border:none;color:#fff;width:26px;height:26px;border-radius:50%;cursor:pointer;font-size:15px;line-height:1;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>
    <!-- Summary -->
    <div id="routeSummary" style="padding:10px 14px;background:#f0f4ff;border-bottom:1px solid #dde8ff;display:flex;gap:16px;flex-shrink:0;">
        <div style="text-align:center;">
            <div style="font-size:18px;font-weight:700;color:#1a73e8;" id="routeDistance">—</div>
            <div style="font-size:10px;color:#666;text-transform:uppercase;letter-spacing:0.4px;">Distance</div>
        </div>
        <div style="text-align:center;">
            <div style="font-size:18px;font-weight:700;color:#395272;" id="routeDuration">—</div>
            <div style="font-size:10px;color:#666;text-transform:uppercase;letter-spacing:0.4px;">Est. Time</div>
        </div>
    </div>
    <!-- Steps -->
    <div id="routeSteps" style="overflow-y:auto;flex:1;padding:8px 0;"></div>
</div>

</div>

<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disclaimerLabel">Disclaimer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <p class="p-modal text-justify">Every attempt has been made to ensure the completeness and accuracy of the most updated information and data available. Clients are advised, however, that provided information, and data is subject to change.</p>
       <h5 class="modal-title" id="disclaimerLabel">Google Maps Link</h5>
       <p class="p-modal text-justify">Google Maps may automatically display or translate content based on the user’s current region, browser settings, or Google account preferences. This issue may occur when opening google maps link from TCMT platform using Microsoft Edge. For the best experience, we recommend opening the Google Chrome link while logged into your Google account. You can also use your browser’s translation feature to view Google Maps in your preferred language.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police1Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/Layer1.png') }}" style="width:15px; height:15px;">
            <h5 class="modal-title" id="disclaimerLabel">National Police (HQ)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal text-justify">
            <strong>Command Level:</strong>&nbsp;National Police Commander
        </p>
        <p class="p-modal text-justify">
            <strong>Typical Head Rank:</strong>&nbsp;Police General (4-star)
        </p>
        <p class="p-modal text-justify">
            <strong>Role:</strong>&nbsp;Highest commander of the CNP
        </p>
        <p class="p-modal text-justify">
            Exercises overall command, strategic leadership, and operational control of the CNP, implementing national internal security policies under the authority of the Minister of Interior.
        </p>
        <p class="p-modal text-justify">
            <strong>Responsibilities:</strong>
        </p>
        <ul>
            <li>Direct and supervise all national, specialized, and territorial police forces.</li>
            <li>Formulate national policing strategies, operational priorities, and organizational policies.</li>
            <li>Maintain public security, public order, and crime prevention throughout Cambodia.</li>
            <li>Coordinate nationwide law enforcement operations and emergency responses.</li>
            <li>Oversee criminal investigations and major security operations of national significance.</li>
            <li>Manage personnel appointments, promotions, discipline, and professional standards across the CNP.</li>
            <li>Represent the CNP before the Royal Government, foreign law enforcement agencies, and international organizations.</li>
            <li>Advise the Minister of Interior on policing, public security, and internal security matters.</li>
            <li>Ensure effective coordination between the CNP, the judiciary, the Royal Cambodian Armed Forces, and other government institutions.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police2Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="{{ asset('images/Layer2.png') }}" style="width:15px; height:15px;">
            <h5 class="modal-title" id="disclaimerLabel">Provincial / Municipal Police Commissariat</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal text-justify">
            <strong>Title:</strong>&nbsp;Provincial / Municipal Police Commissioner
        </p>
        <p class="p-modal text-justify">
            <strong>Command Level:</strong>&nbsp;Top territorial police command
        </p>
        <p class="p-modal text-justify">
            <strong>Typical Head Rank:</strong>&nbsp;Police Brigadier General (1-star) or Police Major General (2-star)
        </p>
        <p class="p-modal text-justify">
            <strong>Administrative Equivalent:</strong>&nbsp;Provincial/Municipality level
        </p>
        <p class="p-modal text-justify">
            Functions as the highest territorial command of the CNP within each province or the capital municipality, directing all policing, security, criminal investigation, and public order operations within its jurisdiction.
        </p>
        <p class="p-modal text-justify">
            <strong>Responsibilities:</strong>
        </p>
        <ul>
            <li>Command and supervise all district police inspectorates within the province or municipality.</li>
            <li>Implement national policing policies and operational directives.</li>
            <li>Coordinate crime prevention, criminal investigations, and public order operations.</li>
            <li>Manage emergency response and disaster-related policing activities.</li>
            <li>Coordinate security for national events, elections, and VIP visits.</li>
            <li>Cooperate with provincial and municipal governors and other government agencies.</li>
            <li>Supervise personnel administration, logistics, and operational readiness within the jurisdiction.</li>
        </ul>
        <p class="p-modal text-justify">
            Report operational developments and security assessments to the Commissioner-General.
        </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police3Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="{{ asset('images/Layer3.png') }}" style="width:15px; height:15px;">
            <h5 class="modal-title" id="disclaimerLabel">District Police Inspectorate</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal text-justify">
            <strong>Title:</strong>&nbsp;District Police Inspector
        </p>
        <p class="p-modal text-justify">
            <strong>Command Level:</strong>&nbsp;Second-tier territorial police command
        </p>
        <p class="p-modal text-justify">
            <strong>Typical Head Rank:</strong>&nbsp;Police Lieutenant Colonel or Police Colonel
        </p>
        <p class="p-modal text-justify">
            <strong>Administrative Equivalent:</strong>&nbsp;District level
        </p>
        <p class="p-modal text-justify">
            Directs and coordinates policing activities within a district by supervising commune police posts and implementing provincial policing priorities.
        </p>
        <p class="p-modal text-justify">
            <strong>Responsibilities:</strong>
        </p>
        <ul>
            <li>Supervise commune police posts.</li>
            <li>Conduct district-level law enforcement and crime prevention operations.</li>
            <li>Coordinate criminal investigations within the district.</li>
            <li>Maintain public order during local events and emergencies.</li>
            <li>Support provincial police operations and specialized investigations.</li>
            <li>Coordinate with district administrative authorities and local institutions.</li>
            <li>Monitor crime trends and public security conditions.</li>
            <li>Submit operational and intelligence reports to the Provincial or Municipal Police Commissariat.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police4Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="{{ asset('images/Layer4.png') }}" style="width:15px; height:15px;">
            <h5 class="modal-title" id="disclaimerLabel">Commune Police Post</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal text-justify">
            <strong>Title:</strong>&nbsp;Chief of Commune Police Post
        </p>
        <p class="p-modal text-justify">
            <strong>Command Level:</strong>&nbsp;Third-tier territorial police command <em>(Frontline operational unit)</em>
        </p>
        <p class="p-modal text-justify">
            <strong>Typical Head Rank:</strong>&nbsp;Police Captain or Police Major
        </p>
        <p class="p-modal text-justify">
            <strong>Administrative Equivalent:</strong>&nbsp;Communal level
        </p>
        <p class="p-modal text-justify">
            Provides frontline policing services at the community level through preventive patrols, first-response law enforcement, community engagement, and maintenance of public order.
        </p>
        <p class="p-modal text-justify">
            <strong>Responsibilities:</strong>
        </p>
        <ul>
            <li>Conduct routine patrols and visible police presence within the community.</li>
            <li>Respond to emergencies, crimes, and public complaints.</li>
            <li>Prevent and detect criminal activities.</li>
            <li>Receive and process initial reports of criminal and public order incidents.</li>
            <li>Carry out community policing and crime prevention programs.</li>
            <li>Maintain peace and public order during local events.</li>
            <li>Gather local intelligence and monitor community security issues.</li>
            <li>Cooperate with commune authorities and community leaders to address local safety concerns.</li>
            <li>Refer serious criminal investigations to the District Police Inspectorate or specialized investigative units as appropriate.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level1Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Private Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Also known as private airfields or airstrips are primarily used for general and private aviation are owned by private individuals, groups, corporations, or organizations operated for their exclusive use that may include limited access for authorized personnel by the owner or manager. Owners are responsible to ensure safe operation, maintenance, repair, and control of who can use the facilities. Typically, they are not open to the public or provide scheduled commercial airline services and cater to private pilots, business aviation, and sometimes small charter operations. Services may be provided if authorized by the appropriate regulatory authority.</p>

        <p class="p-modal">A large majority of private airports are grass or dirt strip fields without services or facilities, they may feature amenities such as hangars, fueling facilities, maintenance services, and ground transportation options tailored to the needs of their owners or users. Private airports are not subject to the same level of regulatory oversight as public airports, but must still comply with applicable aviation regulations, safety standards, and environmental requirements. In the event of an emergency, landing at a private airport is authorized without any prior approval and should be done if landing anywhere else compromises the safety of the aircraft, crew, passengers, or cargo.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level2Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Combined Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Also called "joint-use airport," are used by both civilian and military aircraft, where a formal agreement exists between the military and a local government agency allowing shared access to infrastructure and facilities, typically with separate passenger terminals and designated operating areas, airspace allocation, and aircraft scheduling. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level3Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Military Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level4Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Regional Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">A small or remote regional domestic airfield usually located in a geographically isolated area, far from major population centers, often with difficult terrain or vast distances from other airports with limited passenger traffic. May have shorter runways, basic facilities, and limited amenities, and basic infrastructure, serving primarily local communities providing access to essential services like medical transport or regional travel, rather than large-scale commercial flights.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level5Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Exclusively manages flights that originate and end within the same country, does not have international customs or border control facilities. Airport often has smaller and shorter runways, suitable for smaller regional aircraft used on domestic routes, and cannot support larger haul aircraft having less developed support services. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level6Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">International Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Meet standards set by the International Air Transport Association (IATA) and the International Civil Aviation Organization (ICAO), facilitate transnational travel managing flights between countries, have customs and border control facilities to manage passengers and cargo, and may have dedicated terminals for domestic and international flights. International airports have longer runways to accommodate larger, heavier aircraft, are often a main hub for air traffic, and can serve as a base for larger airlines. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level7Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Military Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade medical-facility-modal" id="level11Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Small Private Hospital</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="level11-medical-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="level11-medical-overview-tab" data-bs-toggle="tab" data-bs-target="#level11-medical-overview" type="button" role="tab" aria-controls="level11-medical-overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level11-medical-role-tab" data-bs-toggle="tab" data-bs-target="#level11-medical-role" type="button" role="tab" aria-controls="level11-medical-role" aria-selected="false">Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level11-medical-clinical-services-tab" data-bs-toggle="tab" data-bs-target="#level11-medical-clinical-services" type="button" role="tab" aria-controls="level11-medical-clinical-services" aria-selected="false">Clinical Services</button>
            </li>
        </ul>
        <div class="tab-content" id="level11-medical-tab-content">
            <div class="tab-pane fade show active" id="level11-medical-overview" role="tabpanel" aria-labelledby="level11-medical-overview-tab" tabindex="0">
                <p class="text-justify">
                    Small Private Hospitals and specialized Maternity Clinic (Pregnancy Care Room) provide basic inpatient and emergency care services. They function as a primary-to-basic-secondary care provider. They focus on general medical treatment, uncomplicated maternal care, minor procedures, and short-term admissions. Complex cases or patients requiring major surgery are stabilized and referred to larger hospitals.
                </p>
            </div>
            <div class="tab-pane fade" id="level11-medical-role" role="tabpanel" aria-labelledby="level11-medical-role-tab" tabindex="0">
                <ul>
                    <li><strong>Primary &amp; Basic Secondary Care:</strong> Provides local inpatient and outpatient medical care, managing common conditions and short-stay admissions.</li>
                    <li class="mt-2"><strong>Maternal &amp; Child Services:</strong> Specialized maternity clinics offer focused antenatal care, normal spontaneous deliveries, and postnatal services.</li>
                    <li class="mt-2"><strong>Emergency Stabilization:</strong> Offers basic 24-hour emergency stabilization prior to upward referral.</li>
                </ul>
                <p class="text-justify">
                    Small Private Hospitals provide medical services and maintain infrastructures comparable to those of the BASIC District Referral Hospitals (CPA1) and Health Centers.
                </p>
            </div>
            <div class="tab-pane fade" id="level11-medical-clinical-services" role="tabpanel" aria-labelledby="level11-medical-clinical-services-tab" tabindex="0">
                <h5 class="fw-bold" style="color:#3c8dbc;">Cambodia Government Health System &amp; Financing</h5>
                <p class="text-justify">
                    Cambodia’s health system financing relies on a mix of government funding, donor support, and social health protection schemes, though Out-Of-Pocket (OOP) spending remains the largest source of health expenditure (accounting for approximately 60%). The government is actively expanding coverage to achieve Universal Health Coverage (UHC) through the following mechanisms:
                </p>

                <h6 class="fw-bold mt-3">Health Equity Funds (HEF)</h6>
                <p class="text-justify">
                    A critical social protection scheme designed to provide free access to public health services for the poorest and most vulnerable populations. The government or donors reimburse public facilities for the care provided to HEF beneficiaries, significantly reducing the barrier of cost for the poor at Health Centers and Referral Hospitals.
                </p>

                <h6 class="fw-bold mt-3">National Social Security Fund (NSSF)</h6>
                <p class="text-justify">
                    A contributory social health insurance scheme that primarily covers formal sector workers, civil servants, and veterans. NSSF finances employment injury benefits and broader health care services, contracting with both public and accredited private health facilities.
                </p>

                <h6 class="fw-bold mt-3">Out-Of-Pocket (OOP) Spending</h6>
                <p class="text-justify">
                    Despite expansion in HEF and NSSF, many Cambodians still rely heavily on OOP payments, primarily driven by a strong cultural preference for utilizing private clinics and pharmacies for initial care before transitioning to the public sector for more severe or prolonged illnesses.
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade medical-facility-modal" id="level22Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">District (CPA1) / Health Center (MPA)</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="level22-medical-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="level22-medical-overview-tab" data-bs-toggle="tab" data-bs-target="#level22-medical-overview" type="button" role="tab" aria-controls="level22-medical-overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level22-medical-role-tab" data-bs-toggle="tab" data-bs-target="#level22-medical-role" type="button" role="tab" aria-controls="level22-medical-role" aria-selected="false">Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level22-medical-clinical-services-tab" data-bs-toggle="tab" data-bs-target="#level22-medical-clinical-services" type="button" role="tab" aria-controls="level22-medical-clinical-services" aria-selected="false">Clinical Services</button>
            </li>
        </ul>
        <div class="tab-content" id="level22-medical-tab-content">
            <div class="tab-pane fade show active" id="level22-medical-overview" role="tabpanel" aria-labelledby="level22-medical-overview-tab" tabindex="0">
                <h5 class="fw-bold" style="color:#3c8dbc;">District Referral Hospital (CPA1)</h5>
                <p class="text-justify">
                    The CPA1 Referral Hospital provides the most basic level of secondary care. While it serves as a referral point within the Operational District, its surgical and critical care capabilities are strictly limited compared to CPA2 and CPA3 facilities.
                </p>

                <h5 class="fw-bold mt-3" style="color:#3c8dbc;">Health Center (MPA)</h5>
                <p class="text-justify">
                    Health Centers (HC) are the frontline primary care facilities in Cambodia, delivering the Minimum Package of Activities (MPA). Designed to serve an optimal catchment size of 10,000 people (within a 10-km radius or 2 hours walking distance), they are the critical first point of contact for the community. HCs focus heavily on outpatient care, preventive medicine, and community outreach.
                </p>
            </div>
            <div class="tab-pane fade" id="level22-medical-role" role="tabpanel" aria-labelledby="level22-medical-role-tab" tabindex="0">
                <ul>
                    <li>First-contact point for basic healthcare needs, health education, and disease prevention.</li>
                    <li>Provide maternal, newborn, child, and reproductive health services.</li>
                    <li>Manage the screening and initial treatment of communicable diseases (HIV/AIDS, TB, Malaria, Dengue) and Non-Communicable Diseases (NCDs like Diabetes and Hypertension).</li>
                    <li>Coordinate community outreach programs and refer complicated cases to Referral Hospitals.</li>
                </ul>
            </div>
            <div class="tab-pane fade" id="level22-medical-clinical-services" role="tabpanel" aria-labelledby="level22-medical-clinical-services-tab" tabindex="0">
                <h5 class="fw-bold" style="color:#3c8dbc;">District Referral Hospital (CPA1)</h5>
                <h6 class="fw-bold">Clinical &amp; Diagnostic Limitations</h6>
                <ul>
                    <li>
                        <strong>No Major Surgery</strong>
                        <ul>
                            <li>CPA1 hospitals do not perform major surgeries and do not provide general anesthesia.</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Obstetric Focus</strong>
                        <ul>
                            <li>They provide basic obstetric services and emergency stabilization.</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>No Blood Transfusion</strong>
                        <ul>
                            <li>CPA1 facilities do not have blood depots or blood banks.</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostics</strong>
                        <ul>
                            <li>Limited to basic laboratory tests and imagery.</li>
                        </ul>
                    </li>
                </ul>

                <h5 class="fw-bold mt-3" style="color:#3c8dbc;">Health Center (MPA)</h5>
                <h6 class="fw-bold">Clinical Services &amp; Staffing</h6>
                <ul>
                    <li><strong>Inpatient Care:</strong> Generally no inpatient admission; designed for outpatient consultation and short-stay observation.</li>
                    <li class="mt-2"><strong>Staffing Standard:</strong> A standard HC requires at least 8-11 personnel, typically comprising 1 Medical Doctor/Assistant, 1-2 Secondary Midwives, 1-2 Primary Midwives, 2 Secondary Nurses, and 2 Primary Nurses.</li>
                    <li class="mt-2"><strong>First Aid &amp; Stabilization:</strong> Capable of providing basic life support and stabilizing urgent cases (e.g., bleeding, shock, snakebites, burns) before referral using the HC's ambulance arrangement.</li>
                </ul>

                <h5 class="fw-bold mt-4" style="color:#3c8dbc;">Cambodia Government Health System &amp; Financing</h5>
                <p class="text-justify">
                    Cambodia’s health system financing relies on a mix of government funding, donor support, and social health protection schemes, though Out-Of-Pocket (OOP) spending remains the largest source of health expenditure (accounting for approximately 60%). The government is actively expanding coverage to achieve Universal Health Coverage (UHC) through the following mechanisms:
                </p>

                <h6 class="fw-bold mt-3">Health Equity Funds (HEF)</h6>
                <p class="text-justify">
                    A critical social protection scheme designed to provide free access to public health services for the poorest and most vulnerable populations. The government or donors reimburse public facilities for the care provided to HEF beneficiaries, significantly reducing the barrier of cost for the poor at Health Centers and Referral Hospitals.
                </p>

                <h6 class="fw-bold mt-3">National Social Security Fund (NSSF)</h6>
                <p class="text-justify">
                    A contributory social health insurance scheme that primarily covers formal sector workers, civil servants, and veterans. NSSF finances employment injury benefits and broader health care services, contracting with both public and accredited private health facilities.
                </p>

                <h6 class="fw-bold mt-3">Out-Of-Pocket (OOP) Spending</h6>
                <p class="text-justify">
                    Despite expansion in HEF and NSSF, many Cambodians still rely heavily on OOP payments, primarily driven by a strong cultural preference for utilizing private clinics and pharmacies for initial care before transitioning to the public sector for more severe or prolonged illnesses.
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade medical-facility-modal" id="level33Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Medium Hospital / Polyclinic HOSPITAL</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="level33-medical-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="level33-medical-overview-tab" data-bs-toggle="tab" data-bs-target="#level33-medical-overview" type="button" role="tab" aria-controls="level33-medical-overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level33-medical-role-tab" data-bs-toggle="tab" data-bs-target="#level33-medical-role" type="button" role="tab" aria-controls="level33-medical-role" aria-selected="false">Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level33-medical-clinical-services-tab" data-bs-toggle="tab" data-bs-target="#level33-medical-clinical-services" type="button" role="tab" aria-controls="level33-medical-clinical-services" aria-selected="false">Clinical Services</button>
            </li>
        </ul>
        <div class="tab-content" id="level33-medical-tab-content">
            <div class="tab-pane fade show active" id="level33-medical-overview" role="tabpanel" aria-labelledby="level33-medical-overview-tab" tabindex="0">
                <p class="text-justify">
                    Medium Private Hospitals or polyclinics provide structured secondary care services within urban or semi-urban settings. They manage common inpatient and surgical cases and offers broad specialist consultations. Their role is to provide accessible private-sector hospital care for routine and moderately complex conditions, while referring highly specialized cases to larger tertiary centers.
                </p>
            </div>
            <div class="tab-pane fade" id="level33-medical-role" role="tabpanel" aria-labelledby="level33-medical-role-tab" tabindex="0">
                <ul>
                    <li><strong>Deliver Secondary Care:</strong> Provide multi-specialty outpatient and inpatient medical and surgical services.</li>
                    <li class="mt-2"><strong>Provide 24-Hour Emergency &amp; Limited Critical Care:</strong> Operate emergency services with stabilization capabilities and basic Intensive Care Unit (ICU) capacity.</li>
                    <li class="mt-2"><strong>Conduct Surgical Services:</strong> Perform general surgeries and procedures requiring general anesthesia within the facility's capability.</li>
                </ul>
                <p class="text-justify">
                    Medium Private Hospitals provide medical services and maintain infrastructures comparable to those of the INTERMEDIATE Provincial (CPA3) and District Referral Hospitals (CPA2).
                </p>
            </div>
            <div class="tab-pane fade" id="level33-medical-clinical-services" role="tabpanel" aria-labelledby="level33-medical-clinical-services-tab" tabindex="0">
                <h5 class="fw-bold" style="color:#3c8dbc;">Cambodia Government Health System &amp; Financing</h5>
                <p class="text-justify">
                    Cambodia’s health system financing relies on a mix of government funding, donor support, and social health protection schemes, though Out-Of-Pocket (OOP) spending remains the largest source of health expenditure (accounting for approximately 60%). The government is actively expanding coverage to achieve Universal Health Coverage (UHC) through the following mechanisms:
                </p>

                <h6 class="fw-bold mt-3">Health Equity Funds (HEF)</h6>
                <p class="text-justify">
                    A critical social protection scheme designed to provide free access to public health services for the poorest and most vulnerable populations. The government or donors reimburse public facilities for the care provided to HEF beneficiaries, significantly reducing the barrier of cost for the poor at Health Centers and Referral Hospitals.
                </p>

                <h6 class="fw-bold mt-3">National Social Security Fund (NSSF)</h6>
                <p class="text-justify">
                    A contributory social health insurance scheme that primarily covers formal sector workers, civil servants, and veterans. NSSF finances employment injury benefits and broader health care services, contracting with both public and accredited private health facilities.
                </p>

                <h6 class="fw-bold mt-3">Out-Of-Pocket (OOP) Spending</h6>
                <p class="text-justify">
                    Despite expansion in HEF and NSSF, many Cambodians still rely heavily on OOP payments, primarily driven by a strong cultural preference for utilizing private clinics and pharmacies for initial care before transitioning to the public sector for more severe or prolonged illnesses.
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade medical-facility-modal" id="level44Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Provincial (CPA3) / District (CPA2) HOSPITAL</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="level44-medical-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="level44-medical-overview-tab" data-bs-toggle="tab" data-bs-target="#level44-medical-overview" type="button" role="tab" aria-controls="level44-medical-overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level44-medical-role-tab" data-bs-toggle="tab" data-bs-target="#level44-medical-role" type="button" role="tab" aria-controls="level44-medical-role" aria-selected="false">Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level44-medical-clinical-services-tab" data-bs-toggle="tab" data-bs-target="#level44-medical-clinical-services" type="button" role="tab" aria-controls="level44-medical-clinical-services" aria-selected="false">Clinical Services</button>
            </li>
        </ul>
        <div class="tab-content" id="level44-medical-tab-content">
            <div class="tab-pane fade show active" id="level44-medical-overview" role="tabpanel" aria-labelledby="level44-medical-overview-tab" tabindex="0">
                <p class="text-justify">
                    Intermediate facilities are secondary care referral hospitals located at the provincial or district level. They are governed by the Operational District (OD) framework and provide the Complementary Package of Activities (CPA). A CPA3 hospital operates primarily at the provincial level and offers more specialized services than a CPA2 hospital, which operates at the district level. Both play a central role in emergency care, surgical interventions, and inpatient management.
                </p>
            </div>
            <div class="tab-pane fade" id="level44-medical-role" role="tabpanel" aria-labelledby="level44-medical-role-tab" tabindex="0">
                <ul>
                    <li>Act as the primary referral destination for Health Centers within their Operational District (optimal catchment of 100,000 population).</li>
                    <li>Provide comprehensive secondary medical and surgical services to manage moderate to complex conditions.</li>
                    <li>Provide clinical training and supportive supervision to Health Centers and Health Posts.</li>
                    <li>Stabilize and refer highly complex or tertiary-level cases to National Hospitals.</li>
                </ul>
            </div>
            <div class="tab-pane fade" id="level44-medical-clinical-services" role="tabpanel" aria-labelledby="level44-medical-clinical-services-tab" tabindex="0">
                <ul>
                    <li>
                        <strong>Bed Capacity</strong>
                        <ul>
                            <li>Approximately 100–250 beds.</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Core Specialties</strong>
                        <ul>
                            <li>General Medicine</li>
                            <li>Surgery</li>
                            <li>Pediatrics</li>
                            <li>Gynecology &amp; Obstetrics</li>
                            <li>
                                Specialized services
                                <ul>
                                    <li>Otolaryngology (Ear, Nose, and Throat)</li>
                                    <li>Ophthalmology</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Emergency &amp; Critical Care</strong>
                        <ul>
                            <li>24-hour Emergency Department</li>
                            <li>Basic Intensive Care Unit (ICU).</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Surgical Capacity</strong>
                        <ul>
                            <li>Both CPA2 and CPA3 operate theatres to perform major surgeries requiring general anesthesia.</li>
                        </ul>
                    </li>
                </ul>

                <h6 class="fw-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
                <ul>
                    <li>
                        <strong>Imaging &amp; Laboratory</strong>
                        <ul>
                            <li>Standard 24/7 laboratory services</li>
                            <li>X-ray</li>
                            <li>Ultrasound</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Blood Services</strong>
                        <ul>
                            <li>CPA3 hospitals operate a Blood Bank</li>
                            <li>CPA2 hospitals operate a Blood Depot (blood storage and basic transfusion capability)</li>
                        </ul>
                    </li>
                </ul>

                <h5 class="fw-bold mt-4" style="color:#3c8dbc;">Cambodia Government Health System &amp; Financing</h5>
                <p class="text-justify">
                    Cambodia’s health system financing relies on a mix of government funding, donor support, and social health protection schemes, though Out-Of-Pocket (OOP) spending remains the largest source of health expenditure (accounting for approximately 60%). The government is actively expanding coverage to achieve Universal Health Coverage (UHC) through the following mechanisms:
                </p>

                <h6 class="fw-bold mt-3">Health Equity Funds (HEF)</h6>
                <p class="text-justify">
                    A critical social protection scheme designed to provide free access to public health services for the poorest and most vulnerable populations. The government or donors reimburse public facilities for the care provided to HEF beneficiaries, significantly reducing the barrier of cost for the poor at Health Centers and Referral Hospitals.
                </p>

                <h6 class="fw-bold mt-3">National Social Security Fund (NSSF)</h6>
                <p class="text-justify">
                    A contributory social health insurance scheme that primarily covers formal sector workers, civil servants, and veterans. NSSF finances employment injury benefits and broader health care services, contracting with both public and accredited private health facilities.
                </p>

                <h6 class="fw-bold mt-3">Out-Of-Pocket (OOP) Spending</h6>
                <p class="text-justify">
                    Despite expansion in HEF and NSSF, many Cambodians still rely heavily on OOP payments, primarily driven by a strong cultural preference for utilizing private clinics and pharmacies for initial care before transitioning to the public sector for more severe or prolonged illnesses.
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade medical-facility-modal" id="level55Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Large Private Hospital</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="level55-medical-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="level55-medical-overview-tab" data-bs-toggle="tab" data-bs-target="#level55-medical-overview" type="button" role="tab" aria-controls="level55-medical-overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level55-medical-role-tab" data-bs-toggle="tab" data-bs-target="#level55-medical-role" type="button" role="tab" aria-controls="level55-medical-role" aria-selected="false">Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level55-medical-clinical-services-tab" data-bs-toggle="tab" data-bs-target="#level55-medical-clinical-services" type="button" role="tab" aria-controls="level55-medical-clinical-services" aria-selected="false">Clinical Services</button>
            </li>
        </ul>
        <div class="tab-content" id="level55-medical-tab-content">
            <div class="tab-pane fade show active" id="level55-medical-overview" role="tabpanel" aria-labelledby="level55-medical-overview-tab" tabindex="0">
                <p class="text-justify">
                    A Large Private Hospital in Cambodia is a high-capacity facility delivering advanced tertiary-level services within the private sector. They function as major private-sector healthcare hubs and strive to meet the highest Cambodian Hospital Accreditation Standards (CHAS), including high-resource "stretch standards." Operating under a license from the Ministry of Health (MOH), it typically serve urban populations, expatriates, and international patients, offering direct access without referral restrictions.
                </p>
            </div>
            <div class="tab-pane fade" id="level55-medical-role" role="tabpanel" aria-labelledby="level55-medical-role-tab" tabindex="0">
                <ul>
                    <li><strong>Deliver Advanced Tertiary Care:</strong> Provide comprehensive multi-specialty and subspecialty medical and surgical services for complex conditions.</li>
                    <li class="mt-2"><strong>Operate Full Emergency &amp; Critical Care Services:</strong> Maintain 24-hour emergency departments and fully equipped Intensive Care Units (ICU) and Neonatal ICUs (NICU).</li>
                    <li class="mt-2"><strong>Provide Advanced Surgical Procedures:</strong> Conduct major complex surgeries using general anesthesia in state-of-the-art operating theaters.</li>
                </ul>
                <p class="text-justify">
                    Large private hospitals provide comprehensive specialist and subspecialist services and are equipped with diagnostic and support infrastructures comparable to the Advanced National Hospitals (CPA3+).
                </p>
            </div>
            <div class="tab-pane fade" id="level55-medical-clinical-services" role="tabpanel" aria-labelledby="level55-medical-clinical-services-tab" tabindex="0">
                <h5 class="fw-bold" style="color:#3c8dbc;">Cambodia Government Health System &amp; Financing</h5>
                <p class="text-justify">
                    Cambodia’s health system financing relies on a mix of government funding, donor support, and social health protection schemes, though Out-Of-Pocket (OOP) spending remains the largest source of health expenditure (accounting for approximately 60%). The government is actively expanding coverage to achieve Universal Health Coverage (UHC) through the following mechanisms:
                </p>

                <h6 class="fw-bold mt-3">Health Equity Funds (HEF)</h6>
                <p class="text-justify">
                    A critical social protection scheme designed to provide free access to public health services for the poorest and most vulnerable populations. The government or donors reimburse public facilities for the care provided to HEF beneficiaries, significantly reducing the barrier of cost for the poor at Health Centers and Referral Hospitals.
                </p>

                <h6 class="fw-bold mt-3">National Social Security Fund (NSSF)</h6>
                <p class="text-justify">
                    A contributory social health insurance scheme that primarily covers formal sector workers, civil servants, and veterans. NSSF finances employment injury benefits and broader health care services, contracting with both public and accredited private health facilities.
                </p>

                <h6 class="fw-bold mt-3">Out-Of-Pocket (OOP) Spending</h6>
                <p class="text-justify">
                    Despite expansion in HEF and NSSF, many Cambodians still rely heavily on OOP payments, primarily driven by a strong cultural preference for utilizing private clinics and pharmacies for initial care before transitioning to the public sector for more severe or prolonged illnesses.
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade medical-facility-modal" id="level66Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">National (CPA3+) Hospital</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="level66-medical-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="level66-medical-overview-tab" data-bs-toggle="tab" data-bs-target="#level66-medical-overview" type="button" role="tab" aria-controls="level66-medical-overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level66-medical-role-tab" data-bs-toggle="tab" data-bs-target="#level66-medical-role" type="button" role="tab" aria-controls="level66-medical-role" aria-selected="false">Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="level66-medical-clinical-services-tab" data-bs-toggle="tab" data-bs-target="#level66-medical-clinical-services" type="button" role="tab" aria-controls="level66-medical-clinical-services" aria-selected="false">Clinical Services</button>
            </li>
        </ul>
        <div class="tab-content" id="level66-medical-tab-content">
            <div class="tab-pane fade show active" id="level66-medical-overview" role="tabpanel" aria-labelledby="level66-medical-overview-tab" tabindex="0">
                <p class="text-justify">
                    The National Hospital is the highest-tier medical facility in Cambodia's public health system under the Ministry of Health (MOH). Providing Complementary Package of Activities (CPA) level 3+, these facilities serve as the ultimate tertiary referral centers. They deliver comprehensive specialist and subspecialist services, complex surgeries, and advanced diagnostics. They also function as major teaching and training institutions for health professionals.
                </p>
            </div>
            <div class="tab-pane fade" id="level66-medical-role" role="tabpanel" aria-labelledby="level66-medical-role-tab" tabindex="0">
                <ul>
                    <li>Serve as the highest referral authority for complex and severe medical cases within the MOH network.</li>
                    <li>Provide specialized medical, surgical, pediatric (e.g., Kantha Bopha), and maternal care.</li>
                    <li>Function as a primary teaching and training center for medical professionals.</li>
                    <li>Lead national outbreak responses and manage severe health security emergencies.</li>
                </ul>
            </div>
            <div class="tab-pane fade" id="level66-medical-clinical-services" role="tabpanel" aria-labelledby="level66-medical-clinical-services-tab" tabindex="0">
                <ul>
                    <li>
                        <strong>Bed Capacity</strong>
                        <ul>
                            <li>Typically &gt; 250 beds, with major national centers ranging from 500 to 1,000+ beds</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Core and Advanced Specialties</strong>
                        <ul>
                            <li>Internal medicine</li>
                            <li>Specialized surgery</li>
                            <li>Obstetrics &amp; gynecology</li>
                            <li>Pediatrics</li>
                            <li>Distinct subspecialties (e.g., ophthalmology, oncology)</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Advanced Emergency &amp; Critical Care</strong>
                        <ul>
                            <li>24-hour emergency department with triage</li>
                            <li>Intensive Care Units (ICU)</li>
                            <li>
                                Specialized resuscitation capabilities
                                <ul>
                                    <li>All staff are trained in Advanced Cardiac Life Support (ACLS)</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Surgical &amp; Interventional Capacity</strong>
                        <ul>
                            <li>
                                Major elective and emergency surgeries utilizing general anesthesia
                                <ul>
                                    <li>Fully-equipped operating theater</li>
                                    <li>Post-anesthesia recovery area</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <h6 class="fw-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
                <ul>
                    <li>
                        <strong>Imaging</strong>
                        <ul>
                            <li>
                                Advanced imagery
                                <ul>
                                    <li>Digital X-ray</li>
                                    <li>Ultrasound</li>
                                    <li>CT Scan</li>
                                    <li>MRI</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Laboratory &amp; Blood Services</strong>
                        <ul>
                            <li>Comprehensive 24/7 laboratory services with strict quality control.</li>
                            <li>Operates a fully functioning Blood Bank for safe blood transfusion services.</li>
                        </ul>
                    </li>
                    <li class="mt-2"><strong>Pharmacy:</strong> Comprehensive formulary management with robust cold chain logistics.</li>
                </ul>

                <h5 class="fw-bold mt-4" style="color:#3c8dbc;">Cambodia Government Health System &amp; Financing</h5>
                <p class="text-justify">
                    Cambodia’s health system financing relies on a mix of government funding, donor support, and social health protection schemes, though Out-Of-Pocket (OOP) spending remains the largest source of health expenditure (accounting for approximately 60%). The government is actively expanding coverage to achieve Universal Health Coverage (UHC) through the following mechanisms:
                </p>

                <h6 class="fw-bold mt-3">Health Equity Funds (HEF)</h6>
                <p class="text-justify">
                    A critical social protection scheme designed to provide free access to public health services for the poorest and most vulnerable populations. The government or donors reimburse public facilities for the care provided to HEF beneficiaries, significantly reducing the barrier of cost for the poor at Health Centers and Referral Hospitals.
                </p>

                <h6 class="fw-bold mt-3">National Social Security Fund (NSSF)</h6>
                <p class="text-justify">
                    A contributory social health insurance scheme that primarily covers formal sector workers, civil servants, and veterans. NSSF finances employment injury benefits and broader health care services, contracting with both public and accredited private health facilities.
                </p>

                <h6 class="fw-bold mt-3">Out-Of-Pocket (OOP) Spending</h6>
                <p class="text-justify">
                    Despite expansion in HEF and NSSF, many Cambodians still rely heavily on OOP payments, primarily driven by a strong cultural preference for utilizing private clinics and pharmacies for initial care before transitioning to the public sector for more severe or prolonged illnesses.
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('service')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd-WVlGgZFJwAtPZkbAEca2Np6OI7CBTM&v=3.64&libraries=places,geometry,drawing"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('click', (e) => {
    const provinceSelectInput = e.target.closest('#provinceSelect .select-input');
    const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');
    const provinceSearch = document.getElementById('provinceSearch');

    if (provinceSelectInput) {
        if (provinceDropdown) provinceDropdown.classList.toggle('show');
    } else {
        const provinceSelect = document.getElementById('provinceSelect');
        if (provinceSelect && !provinceSelect.contains(e.target) && provinceDropdown) {
            provinceDropdown.classList.remove('show');
        }
    }
}, true);

document.addEventListener('keyup', (e) => {
    if (e.target.id === 'provinceSearchInput') {
        const keyword = e.target.value.toLowerCase();
        document.querySelectorAll('#provinceList li').forEach(li => {
            const text = li.textContent.toLowerCase();
            li.style.display = text.includes(keyword) ? '' : 'none';
        });
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('province-checkbox')) {
        const selected = [...document.querySelectorAll('.province-checkbox:checked')]
            .map(cb => cb.parentElement.textContent.trim());
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            if (selected.length === 0) {
                provinceSearch.value = '';
                provinceSearch.placeholder = 'Select Province';
            } else if (selected.length <= 2) {
                provinceSearch.value = selected.join(', ');
            } else {
                provinceSearch.value = selected.length + ' Province Selected';
            }
        }
    }

});
</script>

<script>    // --- Map Initialization ---
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 12.5657, lng: 104.9910 },
        zoom: 6,
        mapTypeId: 'roadmap',
        mapTypeControl: true,
        fullscreenControl: true,
        streetViewControl: false
    });    // --- Global States ---
    let airportMarkers = [];
    let hospitalMarkers = [];
    let policeMarkers = [];
    let embassyMarkers = [];
    const infoWindow = new google.maps.InfoWindow();
    let drawnPolygonGeoJSON = null;
    let radiusCircle = null;
    let radiusPinMarker = null;
    let lastClickedLocation = null;
    let totalHospitals = 0;
    let totalAirports = 0;
    let totalPolice = 0;
    let totalEmbassies = 0;

    // --- Directions (in-map routing) ---
    const directionsService  = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: false,
        polylineOptions: { strokeColor: '#1a73e8', strokeWeight: 5, strokeOpacity: 0.85 }
    });
    directionsRenderer.setMap(map);

    // "Clear Route" button
    const clearRouteBtn = document.createElement('div');
    clearRouteBtn.id = 'clearRouteBtn';
    clearRouteBtn.innerHTML = '✕ Clear Route';
    Object.assign(clearRouteBtn.style, {
        display: 'none',
        background: '#fff',
        border: '2px solid rgba(0,0,0,0.2)',
        borderRadius: '6px',
        padding: '6px 12px',
        fontSize: '13px',
        fontWeight: '600',
        cursor: 'pointer',
        margin: '10px',
        color: '#d32f2f',
        boxShadow: '0 2px 6px rgba(0,0,0,0.15)'
    });
    clearRouteBtn.title = 'Clear the current route';
    clearRouteBtn.addEventListener('click', () => {
        directionsRenderer.setDirections({ routes: [] });
        clearRouteBtn.style.display = 'none';
    });
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(clearRouteBtn);

    // --- Nearby Category Bar (Google Maps style) ---
    let categoryMarkers   = [];
    let activeCategoryBtn = null;

    const categoryBar = document.createElement('div');
    categoryBar.id = 'nearbyCategBar';
    Object.assign(categoryBar.style, {
        display:       'none',
        background:    'transparent',
        padding:       '8px 10px 0',
        display:       'none',
        gap:           '8px',
        flexWrap:      'nowrap',
        overflowX:     'auto',
        maxWidth:      '90vw',
        scrollbarWidth:'none'
    });

    const nearbyCategories = [
        { label: 'Hotels', icon: '🏨', type: 'lodging' }
    ];

    nearbyCategories.forEach(cat => {
        const btn = document.createElement('button');
        btn.textContent = cat.icon + ' ' + cat.label;
        Object.assign(btn.style, {
            display:      'inline-flex',
            alignItems:   'center',
            gap:          '4px',
            padding:      '6px 14px',
            borderRadius: '20px',
            border:       '1px solid rgba(0,0,0,0.12)',
            background:   '#fff',
            color:        '#222',
            fontSize:     '13px',
            fontWeight:   '500',
            cursor:       'pointer',
            whiteSpace:   'nowrap',
            boxShadow:    '0 1px 4px rgba(0,0,0,0.15)',
            transition:   'all 0.15s'
        });

        btn.addEventListener('click', () => {
            if (activeCategoryBtn === btn) {
                // toggle off
                clearCategoryMarkers();
                resetCategoryBtn(btn);
                activeCategoryBtn = null;
                return;
            }
            if (activeCategoryBtn) resetCategoryBtn(activeCategoryBtn);
            activeCategoryBtn = btn;
            btn.style.background = '#1a73e8';
            btn.style.color      = '#fff';
            btn.style.borderColor= '#1a73e8';
            showNearbyCategory(cat.type, cat.label);
        });

        categoryBar.appendChild(btn);
    });

    map.controls[google.maps.ControlPosition.TOP_CENTER].push(categoryBar);

    function resetCategoryBtn(btn) {
        btn.style.background  = '#fff';
        btn.style.color       = '#222';
        btn.style.borderColor = 'rgba(0,0,0,0.12)';
    }

    function clearCategoryMarkers() {
        categoryMarkers.forEach(m => m.setMap(null));
        categoryMarkers = [];
    }

    function showNearbyCategory(type, label) {
        if (!lastClickedLocation) return;
        clearCategoryMarkers();

        const center  = new google.maps.LatLng(lastClickedLocation.lat, lastClickedLocation.lng);
        const service = new google.maps.places.PlacesService(map);

        // Color map per category
        const iconColors = {
            lodging:    '#1a73e8',
            restaurant: '#e53935',
            pharmacy:   '#2e7d32',
            atm:        '#f57c00',
            parking:    '#1565c0',
            cafe:       '#6d4c41',
            hospital:   '#c62828',
        };
        const color = iconColors[type] || '#555';

        function makeSvgIcon(col) {
            const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='32' height='40' viewBox='0 0 32 40'>`
                      + `<path d='M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24S32 28 32 16C32 7.16 24.84 0 16 0z' fill='${col}'/>`
                      + `<circle cx='16' cy='16' r='7' fill='#fff'/>`
                      + `</svg>`;
            return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
        }

        service.nearbySearch({ location: center, radius: 5000, type }, (results, status) => {
            if (status !== google.maps.places.PlacesServiceStatus.OK) {
                if (status === 'ZERO_RESULTS') {
                    alert(`No ${label.toLowerCase()} found within 5 km.`);
                } else {
                    alert(`Failed to load ${label.toLowerCase()}. Error status: ${status}. Please ensure "Places API" is enabled and billing is active.`);
                    console.error('PlacesService nearbySearch failed with status:', status);
                }
                return;
            }
            if (!results.length) return;

            results.forEach(place => {
                if (!place.geometry?.location) return;

                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map,
                    title: place.name,
                    icon: { url: makeSvgIcon(color), scaledSize: new google.maps.Size(32, 40) },
                    animation: google.maps.Animation.DROP
                });

                const dist     = google.maps.geometry.spherical.computeDistanceBetween(center, place.geometry.location);
                const distText = dist >= 1000 ? (dist / 1000).toFixed(1) + ' km' : Math.round(dist) + ' m';
                const rating   = place.rating ? `⭐ ${place.rating.toFixed(1)}` : '';
                const destLat  = place.geometry.location.lat();
                const destLng  = place.geometry.location.lng();
                const safeName = (place.name || '').replace(/'/g, "\\'");

                marker.addListener('click', () => {
                    infoWindow.setContent(`
                        <div style="font-size:13px;min-width:190px;">
                            <h5 style="border-bottom:1px solid #ccc;margin:0 0 6px;font-size:14px;">${place.name}</h5>
                            <div style="color:#666;font-size:12px;margin-bottom:3px;">${label}</div>
                            ${rating  ? `<div style="font-size:12px;">${rating}</div>` : ''}
                            <div style="margin-top:4px;font-size:12px;color:#555;"> ${distText} from search location</div>
                            <div style="margin-top:8px;">
                                <button onclick="showRouteOnMap(${center.lat()},${center.lng()},${destLat},${destLng},'${safeName}')"
                                        style="display:inline-flex;align-items:center;gap:5px;
                                               background:#1a73e8;color:#fff;border:none;
                                               padding:5px 12px;border-radius:6px;font-size:12px;
                                               font-weight:500;cursor:pointer;">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                        <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                                    </svg>
                                    Get Directions
                                </button>
                            </div>
                        </div>`);
                    infoWindow.open(map, marker);
                });

                categoryMarkers.push(marker);
            });
        });
    }

    // Helper: close route panel
    function closeRoutePanel() {
        const panel = document.getElementById('routePanel');
        if (panel) panel.style.display = 'none';
        directionsRenderer.setDirections({ routes: [] });
        clearRouteBtn.style.display = 'none';
    }

    // Helper: draw route on map + show panel
    function showRouteOnMap(originLat, originLng, destLat, destLng, destName) {
        directionsService.route({
            origin: new google.maps.LatLng(originLat, originLng),
            destination: new google.maps.LatLng(destLat, destLng),
            travelMode: google.maps.TravelMode.DRIVING
        }, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
                clearRouteBtn.style.display = 'inline-block';
                infoWindow.close();

                // --- Populate Route Panel ---
                const leg = result.routes[0].legs[0];
                const panel = document.getElementById('routePanel');
                document.getElementById('routePanelTitle').textContent = destName || 'Destination';
                document.getElementById('routeDistance').textContent  = leg.distance.text;
                document.getElementById('routeDuration').textContent  = leg.duration.text;

                const stepsEl = document.getElementById('routeSteps');
                stepsEl.innerHTML = leg.steps.map((step, i) => {
                    const raw = (step.html_instructions || step.instructions || '');
                    const instruction = raw.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                    if (!instruction) return ''; // skip steps with no text
                    const icons = {
                        'Turn left':        '↰',
                        'Turn right':       '↱',
                        'Keep left':        '↖',
                        'Keep right':       '↗',
                        'Continue':         '↑',
                        'Head':             '↑',
                        'Roundabout':       '↻',
                        'U-turn':           '⟳',
                        'Merge':            '↑',
                        'Ramp':             '↗',
                        'Destination':      '📍',
                    };
                    let icon = '•';
                    for (const [key, val] of Object.entries(icons)) {
                        if (instruction.startsWith(key)) { icon = val; break; }
                    }
                    const isLast = i === leg.steps.length - 1;
                    return `
                        <div style="display:flex;gap:10px;padding:8px 14px;
                                    border-bottom:${isLast ? 'none' : '1px solid #f0f0f0'};
                                    align-items:flex-start;">
                            <div style="min-width:22px;height:22px;background:${isLast ? '#395272' : '#e8f0fe'};
                                        border-radius:50%;display:flex;align-items:center;
                                        justify-content:center;font-size:12px;
                                        color:${isLast ? '#fff' : '#1a73e8'};flex-shrink:0;margin-top:1px;">
                                ${icon}
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:12px;color:#222;line-height:1.4;">${instruction}</div>
                                <div style="font-size:11px;color:#888;margin-top:2px;">${step.distance.text}</div>
                            </div>
                        </div>`;
                }).join('');

                panel.style.display = 'flex';
            } else {
                if (status === 'ZERO_RESULTS') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Route Not Found',
                        text: 'No driving route could be found between your location and the destination. The two locations may not be connected by road.',
                        confirmButtonColor: '#1a73e8',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Directions Error',
                        text: 'Could not get directions: ' + status,
                        confirmButtonColor: '#1a73e8',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    }

    // --- Polygon Draw (Custom Point-by-Point) ---
    let isDrawingPolygon = false;
    let polygonLatLngs = [];
    let activePolygon = null;
    let activePolyline = null;
    let cursorPolyline = null;
    let startMarker = null;

    const drawButton = document.createElement('div');
    drawButton.innerHTML = '⬟';
    drawButton.style.backgroundColor = 'white';
    drawButton.style.border = '2px solid rgba(0,0,0,0.2)';
    drawButton.style.borderRadius = '4px';
    drawButton.style.width = '34px';
    drawButton.style.height = '34px';
    drawButton.style.textAlign = 'center';
    drawButton.style.lineHeight = '30px';
    drawButton.style.fontSize = '18px';
    drawButton.style.cursor = 'pointer';
    drawButton.style.margin = '10px';
    drawButton.title = 'Draw Polygon (Click point by point, click starting point to finish)';

    map.controls[google.maps.ControlPosition.LEFT_TOP].push(drawButton);

    const clearButton = document.createElement('div');
    clearButton.innerHTML = '🗑️';
    clearButton.style.backgroundColor = 'white';
    clearButton.style.border = '2px solid rgba(0,0,0,0.2)';
    clearButton.style.borderRadius = '4px';
    clearButton.style.width = '34px';
    clearButton.style.height = '34px';
    clearButton.style.textAlign = 'center';
    clearButton.style.lineHeight = '30px';
    clearButton.style.fontSize = '16px';
    clearButton.style.cursor = 'pointer';
    clearButton.style.margin = '10px 0';
    clearButton.title = 'Clear Polygon';

    map.controls[google.maps.ControlPosition.LEFT_TOP].push(clearButton);

    drawButton.addEventListener('click', () => {
        isDrawingPolygon = !isDrawingPolygon;
        if (isDrawingPolygon) {
            map.setOptions({ draggable: false });
            drawButton.style.backgroundColor = '#ccc';
            map.getDiv().style.cursor = 'crosshair';
            polygonLatLngs = [];
            if (activePolygon) activePolygon.setMap(null);
            if (activePolyline) activePolyline.setMap(null);
            if (cursorPolyline) cursorPolyline.setMap(null);
            if (startMarker) startMarker.setMap(null);
            activePolygon = null;
            activePolyline = new google.maps.Polyline({
                path: polygonLatLngs,
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                strokeWeight: 3,
                clickable: false,
                map: map
            });
            cursorPolyline = new google.maps.Polyline({
                path: [],
                strokeColor: '#0000FF',
                strokeOpacity: 0.5,
                strokeWeight: 3,
                clickable: false,
                map: map
            });
            startMarker = null;
            drawnPolygonGeoJSON = null;
        } else {
            finishPolygon();
        }
    });

    map.addListener('click', (e) => {
        if (!isDrawingPolygon) return;
        polygonLatLngs.push(e.latLng);
        activePolyline.setPath(polygonLatLngs);

        if (polygonLatLngs.length === 1) {
            startMarker = new google.maps.Marker({
                position: e.latLng,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 6,
                    fillColor: '#FFFFFF',
                    fillOpacity: 1,
                    strokeColor: '#0000FF',
                    strokeWeight: 2,
                },
                zIndex: 999
            });
            startMarker.addListener('click', () => {
                if (isDrawingPolygon) finishPolygon();
            });
        }
    });

    map.addListener('mousemove', (e) => {
        if (!isDrawingPolygon || polygonLatLngs.length === 0) return;
        const lastPoint = polygonLatLngs[polygonLatLngs.length - 1];
        cursorPolyline.setPath([lastPoint, e.latLng]);
    });

    map.addListener('rightclick', () => {
        if (isDrawingPolygon) finishPolygon();
    });

    async function finishPolygon() {
        if (!isDrawingPolygon) return;
        isDrawingPolygon = false;
        map.setOptions({ draggable: true });
        drawButton.style.backgroundColor = 'white';
        map.getDiv().style.cursor = '';
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);

        if (polygonLatLngs.length > 2) {
            if (activePolyline) activePolyline.setMap(null);
            activePolygon = new google.maps.Polygon({
                paths: polygonLatLngs,
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: '#0000FF',
                fillOpacity: 0.2,
                editable: true,
                map: map
            });

            const coordinates = polygonLatLngs.map(p => [p.lng(), p.lat()]);
            coordinates.push([polygonLatLngs[0].lng(), polygonLatLngs[0].lat()]); // Close polygon

            drawnPolygonGeoJSON = {
                type: "Feature",
                geometry: { type: "Polygon", coordinates: [coordinates] },
                properties: {}
            };

            const updatePolygonFilter = async () => {
                if (!activePolygon) return;
                const path = activePolygon.getPath();
                if (path.getLength() > 2) {
                    const newCoords = [];
                    for (let i = 0; i < path.getLength(); i++) {
                        const xy = path.getAt(i);
                        newCoords.push([xy.lng(), xy.lat()]);
                    }
                    newCoords.push([path.getAt(0).lng(), path.getAt(0).lat()]);
                    drawnPolygonGeoJSON.geometry.coordinates = [newCoords];
                    await refreshCurrentFilters();
                }
            };

            google.maps.event.addListener(activePolygon.getPath(), 'set_at', updatePolygonFilter);
            google.maps.event.addListener(activePolygon.getPath(), 'insert_at', updatePolygonFilter);
            google.maps.event.addListener(activePolygon.getPath(), 'remove_at', updatePolygonFilter);

            await refreshCurrentFilters();
        } else {
            if (activePolyline) activePolyline.setMap(null);
            activePolyline = null;
            activePolygon = null;
            drawnPolygonGeoJSON = null;
        }
    }

    clearButton.addEventListener('click', async () => {
        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = null;
        cursorPolyline = null;
        startMarker = null;
        polygonLatLngs = [];
        drawnPolygonGeoJSON = null;
        isDrawingPolygon = false;
        map.setOptions({ draggable: true });
        drawButton.style.backgroundColor = 'white';
        map.getDiv().style.cursor = '';
        await refreshCurrentFilters();
    });    // --- Update Radius ---
    function updateRadiusCircleAndPin(radius = 0) {
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }

        if (radius > 0 && lastClickedLocation) {
            radiusCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.2,
                map: map,
                center: lastClickedLocation,
                radius: radius * 1000
            });
        }
    }

    // Red pin marker for searched location (separate from radius circle)
    function placeLocationPin(location, label) {
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        radiusPinMarker = new google.maps.Marker({
            position: location,
            map: map,
            title: label || 'Selected Location',
            icon: {
                url: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                scaledSize: new google.maps.Size(25, 41)
            },
            zIndex: 9999,
            animation: google.maps.Animation.DROP
        });
    }

    // Enable/disable radius section based on whether location is set
    function setRadiusSectionEnabled(enabled) {
        const section = document.getElementById('radiusSection');
        if (!section) return;
        section.style.opacity = enabled ? '1' : '0.4';
        section.style.pointerEvents = enabled ? 'auto' : 'none';
    }

    // --- Init Location Search — Google Places Autocomplete ---
    // .pac-container is repositioned to position:fixed via MutationObserver
    // to bypass Google Maps container overflow:hidden clipping.
    function initLocationSearch() {
        const input = document.getElementById('locationSearchMap');
        if (!input) {
            setTimeout(initLocationSearch, 300);
            return;
        }

        const clearBtn = document.getElementById('locationSearchClear');

        // ── 1. Create Google Places Autocomplete ──────────────────────────────
        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode', 'establishment'],
            fields: ['geometry', 'name', 'formatted_address']
        });

        // ── 2. Fix .pac-container position to avoid map overflow:hidden ───────
        // Google appends .pac-container to <body> but uses position:absolute,
        // calculated from the element's document offset. Because the map container
        // applies its own offset context, the top/left values are wrong.
        // We override with position:fixed + getBoundingClientRect().
        let pacContainer = null;

        function fixPacPosition() {
            if (!pacContainer) return;
            const rect = input.getBoundingClientRect();
            pacContainer.style.position   = 'fixed';
            pacContainer.style.zIndex     = '2147483647';
            pacContainer.style.top        = (rect.bottom + 2) + 'px';
            pacContainer.style.left       = rect.left + 'px';
            pacContainer.style.width      = rect.width + 'px';
            pacContainer.style.borderRadius = '0 0 8px 8px';
            pacContainer.style.boxShadow  = '0 8px 24px rgba(0,0,0,0.2)';
            pacContainer.style.fontFamily = 'inherit';
        }

        // Watch for Google to inject .pac-container into <body>
        const observer = new MutationObserver(() => {
            if (!pacContainer) {
                pacContainer = document.querySelector('.pac-container');
                if (pacContainer) {
                    fixPacPosition();
                    // Re-fix on every style mutation (Google repositions it on scroll etc.)
                    new MutationObserver(fixPacPosition).observe(
                        pacContainer, { attributes: true, attributeFilter: ['style'] }
                    );
                }
            }
        });
        observer.observe(document.body, { childList: true, subtree: false });

        // Keep in sync with input position on scroll / resize
        window.addEventListener('scroll', fixPacPosition, true);
        window.addEventListener('resize', fixPacPosition);
        input.addEventListener('focus',  fixPacPosition);
        input.addEventListener('input',  fixPacPosition);

        // ── 3. Prevent map from capturing keyboard input ───────────────────────
        google.maps.event.addDomListener(input, 'keydown',   e => e.stopPropagation());
        google.maps.event.addDomListener(input, 'mousedown', e => e.stopPropagation());

        // ── 4. Focus styling ───────────────────────────────────────────────────
        input.addEventListener('focus', () => {
            input.style.borderColor = '#1a73e8';
            input.style.boxShadow   = '0 0 0 3px rgba(26,115,232,0.15)';
        });
        input.addEventListener('blur', () => {
            input.style.borderColor = '#ddd';
            input.style.boxShadow   = 'none';
        });

        // Show/hide × button
        input.addEventListener('input', () => {
            if (clearBtn) clearBtn.style.display = input.value.length ? 'inline' : 'none';
        });

        // ── 5. Handle place selection ─────────────────────────────────────────
        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) return;

            const loc = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };
            lastClickedLocation = loc;

            map.panTo(loc);
            map.setZoom(10);

            const label = place.name || place.formatted_address || 'Location';
            placeLocationPin(loc, label);

            if (clearBtn) clearBtn.style.display = 'inline';

            const badge    = document.getElementById('locationFoundBadge');
            const badgeName = document.getElementById('locationFoundName');
            if (badge)     badge.style.display = 'block';
            if (badgeName) badgeName.textContent = label;

            setRadiusSectionEnabled(true);
            const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
            updateRadiusCircleAndPin(radius);
            refreshCurrentFilters();

            // Show category bar
            categoryBar.style.display = 'flex';
        });

        // ── 6. Clear button ───────────────────────────────────────────────────
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                input.value = '';
                clearBtn.style.display = 'none';
                if (pacContainer) pacContainer.style.display = 'none';

                const badge = document.getElementById('locationFoundBadge');
                if (badge) badge.style.display = 'none';

                if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
                if (radiusCircle)    { radiusCircle.setMap(null);    radiusCircle    = null; }
                lastClickedLocation = null;

                // Hide category bar & clear category markers
                categoryBar.style.display = 'none';
                clearCategoryMarkers();
                if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

                setRadiusSectionEnabled(false);
                const rEl    = document.getElementById('radiusRangeMap');
                const rValEl = document.getElementById('radiusValueMap');
                if (rEl)    rEl.value          = 0;
                if (rValEl) rValEl.textContent = '0';

                refreshCurrentFilters();
                input.focus();
            });
        }
    }

    // --- Fetch Data ---
    async function fetchData(url, filters = {}) {
        const params = new URLSearchParams();
        Object.entries(filters).forEach(([k, v]) => {
            if (Array.isArray(v)) v.forEach(x => params.append(`${k}[]`, x));
            else if (v !== '' && v != null) params.append(k, v);
        });
        if (drawnPolygonGeoJSON) params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        //  console.log(url + '?' + params.toString());

        try {
            const res = await fetch(`${url}?${params.toString()}`);
            return res.ok ? await res.json() : [];
        } catch (e) {
            console.error(`Error fetching ${url}:`, e);
            return [];
        }
    }    // --- Add Markers ---
    function clearMarkers(markersArray) {
        if (!markersArray) return;
        markersArray.forEach(m => m.setMap(null));
        markersArray.length = 0;
    }

    function addMarkers(data, markersArray, defaultIconUrl) {
        clearMarkers(markersArray);
        data.forEach(item => {
            if (!item || !item.latitude || !item.longitude) return;

            let iconSize = new google.maps.Size(24, 24);

            // Police icon lebih kecil
            if (item.name_police) {
                iconSize = new google.maps.Size(12, 12);
            }

            const iconUrl = item.icon || defaultIconUrl || 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png';

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(item.latitude), lng: parseFloat(item.longitude) },
                map: map,
                icon: {
                    url: iconUrl,
                    scaledSize: iconSize
                }
            });

            let itemName = '', detailUrl = '', popupContent = '';

            if (item.airport_name) {
                itemName = item.airport_name;
                detailUrl = `/airports/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Classification:</strong> ${item.category || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city_name ? ', ' + item.city_name : ''}
                        ${item.district_name ? ', ' + item.district_name : ''}
                        ${item.province_name ? ', ' + item.province_name : ''}, Cambodia <br>
                    <strong>Website:</strong> ${item.website || 'N/A'} <br>
                `;
            } else if (item.name) {
                itemName = item.name;
                detailUrl = `/hospitals/${item.id}`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Global Classification:</strong> ${item.facility_category || 'N/A'}<br>
                    <strong>Country Classification:</strong> ${item.facility_level || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city ? ', ' + item.city : ''}
                        ${item.district ? ', ' + item.district : ''}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Cambodia <br>
                `;
            } else if (item.name_police) {
                itemName = item.name_police;
                detailUrl = `/police/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Category:</strong> ${item.category || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.location || 'N/A'}
                        ${item.city_name ? ', ' + item.city_name : ''}
                        ${item.district_name ? ', ' + item.district_name : ''}
                        ${item.province_name ? ', ' + item.province_name : ''}, Cambodia <br>
                    <strong>Phone:</strong> ${item.telephone || 'N/A'}<br>
                    <strong>Fax:</strong> ${item.fax || 'N/A'}<br>
                    <strong>Email:</strong> ${item.email || 'N/A'}<br>
                    <strong>Website:</strong> ${item.website || 'N/A'}<br>
                `;
            }
            else if (item.name_embassiees) {
                itemName = item.name_embassiees;
                detailUrl = `/embassiees/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city ? ', ' + item.city : ''}
                        ${item.district ? ', ' + item.district : ''}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Cambodia <br>
                    <strong>Phone:</strong> ${item.telephone || 'N/A'}<br>
                    <strong>Fax:</strong> ${item.fax || 'N/A'}<br>
                    <strong>Email:</strong> ${item.email || 'N/A'}<br>
                    <strong>Website:</strong> ${item.website || 'N/A'}<br>
                `;
            }



            marker.addListener('click', () => {
                const destLat = parseFloat(item.latitude);
                const destLng = parseFloat(item.longitude);

                let directionsBtn = '';
                if (lastClickedLocation && !isNaN(destLat) && !isNaN(destLng)) {
                    const oLat = lastClickedLocation.lat;
                    const oLng = lastClickedLocation.lng;
                    directionsBtn = `
                        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;display:flex;gap:6px;flex-wrap:wrap;">
                            <button onclick="showRouteOnMap(${oLat},${oLng},${destLat},${destLng},'${(itemName||'').replace(/'/g,"\\'")}')"
                               style="display:inline-flex;align-items:center;gap:5px;
                                      background:#1a73e8;color:#fff;border:none;
                                      padding:5px 12px;border-radius:6px;font-size:12px;
                                      font-weight:500;cursor:pointer;">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                                </svg>
                                Get Directions
                            </button>
                            <a href="${detailUrl}"
                               style="display:inline-flex;align-items:center;gap:5px;
                                      background:#395272;color:#fff;text-decoration:none;
                                      padding:5px 12px;border-radius:6px;font-size:12px;
                                      font-weight:500;"
                               onmouseover="this.style.background='#5686c3'"
                               onmouseout="this.style.background='#395272'">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                                </svg>
                                Read More
                            </a>
                        </div>`;
                } else if (detailUrl) {
                    directionsBtn = `
                        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;">
                            <a href="${detailUrl}"
                               style="display:inline-flex;align-items:center;gap:5px;
                                      background:#395272;color:#fff;text-decoration:none;
                                      padding:5px 12px;border-radius:6px;font-size:12px;
                                      font-weight:500;"
                               onmouseover="this.style.background='#5686c3'"
                               onmouseout="this.style.background='#395272'">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                                </svg>
                                Read More
                            </a>
                        </div>`;
                }

                infoWindow.setContent(`<div style="font-size:13px; min-width: 200px;">${popupContent}${directionsBtn}</div>`);
                infoWindow.open(map, marker);
            });

            markersArray.push(marker);
        });
    }

    // --- Apply Filters ---
    async function applyFiltersWithMapControl(
        facilities = [],
        hospitalLevels = [],
        airportClasses = [],
        provinces = [],
        radius = 0,
        airportName = '',
        hospitalName = ''
    ) {
        let common = { provinces };
        if (radius > 0 && lastClickedLocation) {
            common.radius = radius;
            common.center_lat = lastClickedLocation.lat;
            common.center_lng = lastClickedLocation.lng;
        }

        totalHospitals = 0;
        totalAirports = 0;
        totalPolice = 0;
        totalEmbassies = 0;

        // jika tidak ada checkbox dipilih => tampilkan semua
        const showAllFacilities = facilities.length === 0;

        const showHospital =
            showAllFacilities || facilities.includes('hospital');

        const showAirport =
            showAllFacilities || facilities.includes('airport');

        const showPolice =
            showAllFacilities || facilities.includes('police');

        const showEmbassy =
            showAllFacilities || facilities.includes('embassy');

         // === HOSPITALS ===
        if (showHospital) {
             const result = await fetchData('/api/hospital', {
                ...common,
                name: hospitalName,
                category: hospitalLevels
            });

            addMarkers(result.hospitals, hospitalMarkers, null);

            totalHospitals = result.hospitals.length;
        } else {
            clearMarkers(hospitalMarkers);
        }

        // === AIRPORTS ===
       if (showAirport) {

            const airportResponse = await fetchData('/api/airports', {
                ...common,
                name: airportName
            });

            const airports = Array.isArray(airportResponse)
                    ? airportResponse
                    : airportResponse.airports || [];
            const categoryCounts = airportResponse.categoryCounts || {};

            const filteredAirports = airports.filter(a => {

                if (airportClasses.length === 0) {
                    return true;
                }

                if (!a.category) {
                    return false;
                }

                const dbCategories = a.category
                    .split(',')
                    .map(c => c.trim().toLowerCase());

                return airportClasses.some(sel =>
                    dbCategories.includes(sel.toLowerCase())
                );
            });

            addMarkers(
                filteredAirports,
                airportMarkers,
                'https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png'
            );

            totalAirports = filteredAirports.length;
        }else {
            clearMarkers(airportMarkers);
        }

        // === POLICE ===
       if (showPolice) {

            const result = await fetchData('/api/polices', {
                ...common
            });

            const police = result.polices || [];
            const categoryCounts = result.categoryCounts || {};

            addMarkers(
                police,
                policeMarkers,
                null
            );

            totalPolice = police.length;

            Object.keys(categoryCounts).forEach(cat => {

                const id = cat.replace(/[^a-zA-Z0-9]/g, '-');

                const el = document.getElementById(`count-${id}`);

                if (el) {
                    el.textContent = categoryCounts[cat];
                }
            });
        } else {
            clearMarkers(policeMarkers);
        }

        // === EMBASSY ===
        if (showEmbassy) {

            const embassies = await fetchData('/api/embassy', {
                ...common
            });

            addMarkers(
                embassies,
                embassyMarkers,
                '/images/embassy-icon-new.png'
            );

            totalEmbassies = embassies.length;

        } else {
            clearMarkers(embassyMarkers);
        }

        updateRadiusCircleAndPin(radius);
        updateTotalCountDisplay();
    }

    function updateTotalCountDisplay() {
        document.getElementById('airportCount').textContent = totalAirports;
        document.getElementById('hospitalCount').textContent = totalHospitals;
        document.getElementById('policeCount').textContent = totalPolice;
        document.getElementById('embassyCount').textContent = totalEmbassies;

        const el = document.getElementById('totalCountDisplay');
    }    // === COMBINED PANEL ===
    const combinedPanelDiv = document.createElement('div');
    combinedPanelDiv.id = 'combinedPanelDiv';
    Object.assign(combinedPanelDiv.style, {
        background: 'white',
        borderRadius: '8px',
        boxShadow: '0 2px 6px rgba(0,0,0,0.2)',
        minWidth: '260px',
        maxWidth: '290px',
        overflow: 'visible',
        margin: '10px'
    });

    combinedPanelDiv.innerHTML = `
        <button style="background:#007bff;color:white;border:none;width:100%;padding:8px;border-radius:8px 8px 0 0;font-weight:600;letter-spacing:0.3px;">Filter &amp; Radius</button>

        <!-- Search Location - NOT inside scrollable div so dropdown is never clipped -->
        <div id="searchSection" style="padding:10px 10px 6px 10px;background:white;position:relative;">
            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;"> Search Location</strong>
            <div style="position:relative;margin-top:5px;">
                <input
                    type="text"
                    id="locationSearchMap"
                    placeholder="Search Location..."
                    autocomplete="off"
                    style="width:100%;padding:7px 30px 7px 9px;border:1.5px solid #ddd;border-radius:6px;font-size:13px;box-sizing:border-box;"
                >
                <span id="locationSearchClear" title="Clear"
                    style="position:absolute;right:8px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:15px;color:#aaa;display:none;">&times;</span>
                <!-- Autocomplete dropdown - inside input wrapper so position relative works correctly -->
                <div id="locationAutocompleteList"
                    style="display:none;position:absolute;left:0;right:0;top:100%;margin-top:2px;background:white;border:1px solid #ddd;border-radius:6px;box-shadow:0 4px 16px rgba(0,0,0,0.18);z-index:999999;max-height:220px;overflow-y:auto;"
                ></div>
            </div>
            <div id="locationFoundBadge" style="display:none;margin-top:6px;background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:4px 8px;font-size:12px;color:#2e7d32;">
                &#128204; <span id="locationFoundName"></span>
            </div>
        </div>

        <!-- Radius - also outside scrollable, enabled after location selected -->
        <div id="radiusSection" style="padding:0 10px 0 10px;opacity:0.4;pointer-events:none;transition:opacity 0.3s;">
            <hr style="margin:8px 0;">
            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">&#11096; Radius: <span id="radiusValueMap">0</span> km</strong>
            <input type="range" id="radiusRangeMap" min="0" max="500" value="0" style="width:100%;margin:4px 0;">
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#888;margin-bottom:5px;">
                <span>0</span><span>250 km</span><span>500 km</span>
            </div>
            <div style="display:flex;gap:5px;margin-bottom:6px;">
                <button id="applyRadiusMap" class="btn btn-sm btn-primary flex-fill">Apply</button>
                <button id="resetRadiusMap" class="btn btn-sm btn-danger flex-fill">Reset</button>
            </div>
        </div>

        <!-- Scrollable filters below -->
        <div id="filterPanel" style="padding:0 10px 10px 10px;max-height:52vh;overflow-y:auto;border-top:1px solid #eee;">
            <div style="padding-top:8px;">
            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Facilities</strong>
                    <div class="facility-list">
                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="airport" id="facilityAirport" checked>
                            <label class="form-check-label" for="facilityAirport">
                                <span class="facility-name">Aviation</span>
                                <span class="facility-count" id="airportCount">0</span>
                            </label>
                        </div>
                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="hospital" id="facilityHospital">
                            <label class="form-check-label" for="facilityHospital">
                                <span class="facility-name">Medical</span>
                                <span class="facility-count" id="hospitalCount">0</span>
                            </label>
                        </div>
                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="police" id="facilityPolice">
                            <label class="form-check-label" for="facilityPolice">
                                <span class="facility-name">Police</span>
                                <span class="facility-count" id="policeCount">0</span>
                            </label>
                        </div>
                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="embassy" id="facilityEmbassy">
                            <label class="form-check-label" for="facilityEmbassy">
                                <span class="facility-name">Embassies</span>
                                <span class="facility-count" id="embassyCount">0</span>
                            </label>
                        </div>
                        <div class="facility-item">
                            <input class="form-check-input" type="checkbox" value="all" id="facilityAll">
                            <label class="form-check-label" for="facilityAll">
                                <span class="facility-name is-all">All / Clear All</span>
                            </label>
                        </div>
                    </div>

                    <hr>
                    <div class="filter-box" id="provinceSelect">
                        <label class="filter-label">
                            Province
                        </label>

                        <div class="select-input">
                            <input
                                type="text"
                                id="provinceSearch"
                                placeholder="Select Province"
                                readonly
                            >
                            <i class="bi bi-chevron-down"></i>
                        </div>

                        <div class="select-dropdown">
                            <input
                                type="text"
                                class="dropdown-search"
                                id="provinceSearchInput"
                                placeholder="Search Province..."
                            >

                            <ul id="provinceList">
                                @foreach($provinces as $province)
                                <li>
                                    <label>
                                        <input
                                            type="checkbox"
                                            class="province-checkbox"
                                            value="{{ $province->id }}"
                                        >
                                        {{ $province->provinces_region }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr>
                    <button id="resetMapFilter"
                            class="btn btn-sm btn-secondary w-100"
                            style="margin-top:auto;">
                        Reset All
                    </button>
                    <div id="totalCountDisplay" style="margin-top:8px;text-align:center;font-size:13px;"></div>
                </div>
            </div>`;            google.maps.event.addDomListener(combinedPanelDiv, 'click', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'dblclick', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'mousedown', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'touchstart', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'wheel', e => e.stopPropagation());
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(combinedPanelDiv);

    // === FACILITIES "ALL" CHECKBOX SYNC ===
    function syncFacilityAllCheckbox() {
        const all = document.getElementById('facilityAll');
        if (!all) return;
        const boxes = [...document.querySelectorAll('.facility-checkbox')];
        all.checked = boxes.length > 0 && boxes.every(cb => cb.checked);
    }

    document.addEventListener('change', e => {
        if (!e.target) return;
        if (e.target.id === 'facilityAll') {
            document.querySelectorAll('.facility-checkbox').forEach(cb => {
                cb.checked = e.target.checked;
            });
            return;
        }
        if (e.target.classList && e.target.classList.contains('facility-checkbox')) {
            syncFacilityAllCheckbox();
        }
    }, true);

    // === INIT SELECT2 ===
    setTimeout(() => {
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select-search-airport').select2({ placeholder: 'Select Airport', width: '100%' });
            $('.select-search-hospital').select2({ placeholder: 'Select Hospital', width: '100%' });
        }
    }, 300);

    function getCurrentFiltersFromUI() {
        const facilities = [...document.querySelectorAll('.facility-checkbox:checked')].map(el => el.value);
        const hLevels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
        const aClasses = [...document.querySelectorAll('input[name="airportClass"]:checked')].map(e => e.value);
        const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
        const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
        // untuk select2, .value akan tetap bekerja because Select2 keeps value in the <select>
        const airportName = document.getElementById('airport_name_map')?.value || '';
        const hospitalName = document.getElementById('hospital_name_map')?.value || '';
        return { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName };
    }

    async function refreshCurrentFilters() {
        const {
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        } = getCurrentFiltersFromUI();

        await applyFiltersWithMapControl(
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        );
    }

    // === Event Logic ===
    document.addEventListener('change', async e => {
        const facilities = [...document.querySelectorAll('.facility-checkbox:checked')].map(el => el.value);
        const hLevels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
        const aClasses = [...document.querySelectorAll('input[name="airportClass"]:checked')].map(e => e.value);
        const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
        const radius = parseInt(document.getElementById('radiusRangeMap').value || 0);
        const airportName = document.getElementById('airport_name_map')?.value || '';
        const hospitalName = document.getElementById('hospital_name_map')?.value || '';

        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
    }, true);

    // === INPUT: update tampilan radius saat slider digeser (live) ===
document.addEventListener('input', (e) => {
    if (e.target && e.target.id === 'radiusRangeMap') {
        const r = parseInt(e.target.value || 0);
        const el = document.getElementById('radiusValueMap');
        if (el) el.textContent = r;
        // hanya update tampilan lingkaran saja (belum apply ke filter)
        updateRadiusCircleAndPin(r);
    }
}, true);

// === CLICK: apply / reset radius dan reset all ===
// Menggunakan event capturing (true) agar tidak diblok oleh stopPropagation pada map control
document.addEventListener('click', async (e) => {
    if (!e.target) return;

    // APPLY RADIUS => ambil filter sekarang lalu panggil applyFiltersWithMapControl dengan radius
    if (e.target.id === 'applyRadiusMap') {
        const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
        if (radius > 0 && !lastClickedLocation) {
            alert('Cari lokasi terlebih dahulu menggunakan kolom "Search Location" sebelum menggunakan filter radius.');
            return;
        }
        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        return;
    }

    // RESET RADIUS (hanya reset radius visual & reapply tanpa radius)
    if (e.target.id === 'resetRadiusMap') {
        const rEl = document.getElementById('radiusRangeMap');
        const rValEl = document.getElementById('radiusValueMap');
        if (rEl) rEl.value = 0;
        if (rValEl) rValEl.textContent = '0';

        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const { facilities, hLevels, aClasses, provs, airportName, hospitalName } = getCurrentFiltersFromUI();
        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, 0, airportName, hospitalName);
        return;
    }

    // RESET ALL FILTERS (tombol Reset All)
    if (e.target.id === 'resetMapFilter') {
        // 1) UI reset (default: hanya Aviation yang aktif)
        document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(cb => { cb.checked = false; });
        const defaultFacility = document.getElementById('facilityAirport');
        if (defaultFacility) defaultFacility.checked = true;
        syncFacilityAllCheckbox();
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) provinceSearch.value = '';
        const provinceSearchInput = document.getElementById('provinceSearchInput');
        if (provinceSearchInput) provinceSearchInput.value = '';
        document.querySelectorAll('#provinceList li').forEach(li => { li.style.display = ''; });

        // sembunyikan sub-panels
        const af = document.getElementById('airportFilter');
        const hf = document.getElementById('hospitalFilter');
        if (af) af.style.display = 'none';
        if (hf) hf.style.display = 'none';

        // 2) Reset Select2 (jika ada)
        if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
            $('.select-search-airport').each(function () { $(this).val(null).trigger('change'); });
            $('.select-search-hospital').each(function () { $(this).val(null).trigger('change'); });
        } else {
            const airportSel = document.getElementById('airport_name_map');
            const hospitalSel = document.getElementById('hospital_name_map');
            if (airportSel) airportSel.value = '';
            if (hospitalSel) hospitalSel.value = '';
        }

        // 3) Reset radius visual & location search
        const radiusRange = document.getElementById('radiusRangeMap');
        const radiusValue = document.getElementById('radiusValueMap');
        if (radiusRange) radiusRange.value = 0;
        if (radiusValue) radiusValue.textContent = '0';
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const locInput = document.getElementById('locationSearchMap');
        const locClear = document.getElementById('locationSearchClear');
        const locBadge = document.getElementById('locationFoundBadge');
        if (locInput) locInput.value = '';
        if (locClear) locClear.style.display = 'none';
        if (locBadge) locBadge.style.display = 'none';

        const fixedDrop = document.getElementById('locationDropdownFixed');
        if (fixedDrop) fixedDrop.style.display = 'none';
        setRadiusSectionEnabled(false);

        // 4) Remove drawn polygon and layers
        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = null;
        cursorPolyline = null;
        startMarker = null;
        polygonLatLngs = [];
        drawnPolygonGeoJSON = null;

        // 5) Clear markers and counters
        if (airportMarkers) clearMarkers(airportMarkers);
        if (hospitalMarkers) clearMarkers(hospitalMarkers);
        if (policeMarkers) clearMarkers(policeMarkers);
        if (embassyMarkers) clearMarkers(embassyMarkers);
        totalAirports = 0;
        totalHospitals = 0;
        totalPolice = 0;
        totalEmbassies = 0;
        updateTotalCountDisplay();

        // 6) Re-fetch semua data
        await applyFiltersWithMapControl(['airport'], [], [], [], 0, '', '');

        e.stopPropagation();
        e.preventDefault();
        return;
    }
}, true);

// === LISTEN TO CHANGE on filter inputs (kategori/provinsi/select nama) ===
// Ini memastikan ketika user change checkbox / select2, filter langsung ter-apply
function bindFilterChangeAutoApply() {
    // checkbox change
    document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(el => {
        el.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    });

    // select2 change (nama)
    // if Select2 is used, listen with jQuery; otherwise plain change event above covers plain <select>
    if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
        $(document).on('change', '#airport_name_map, #hospital_name_map', async function () {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    } else {
        document.getElementById('airport_name_map')?.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
        document.getElementById('hospital_name_map')?.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    }
}

// call binding after panel is rendered
setTimeout(() => {
    bindFilterChangeAutoApply();
    initLocationSearch();
}, 350);

    // --- Initial Load ---
    // Tunggu panel terpasang agar checkbox Aviation terbaca sebagai filter awal.
    (function initialLoad() {
        if (!document.getElementById('facilityAirport')) {
            setTimeout(initialLoad, 100);
            return;
        }
        refreshCurrentFilters();
    })();
</script>

@endpush
