@extends('layouts.master')

@section('title','Detail Clinic')
@section('page-title', 'Cambodia Medical Facility')

@push('styles')

<style>
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

    .clinical-service-table{

    }

    .clinical-service-table td{
        padding: 6px 0;
        border-bottom: 1px solid #dee2e6;
        border-top:none;
        line-height: 18px;
    }

    .card-header{
        padding: 0.25rem 1.25rem;
        color: #3c66b5;
        font-weight: bold;
    }

    .mb-4{
        margin-bottom: 0.5rem !important;
    }

    .clinical-service-table td{
        padding: 6px;
    }

    /* Classification */
    .classification {
      display: flex;
      width: 100%;
    }

    .class-column {
      flex: 1;
      text-align: center;

    }
    .class-column:last-child {
      border-right: none;
    }

    .class-header {
      font-weight: 600;
      padding: 0.1rem 0;
    }

    /* Color bars */
    .class-medical-classification {border: none; text-align: center;}
    .class-airport-category {border: none;}
    .class-advanced { border-bottom: 3px solid #0070c0; }
    .class-intermediate { border-bottom: 3px solid #00b050; }
    .class-basic { border-bottom: 3px solid #ffc000; }

    /* Hospital layout */
    .hospital-list {
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    /* For side-by-side classes */
    .hospital-row {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
    }

    .hospital-item {
      display: flex;
      align-items: center;
      gap: 0;
      font-size: 0.9rem;
      white-space: nowrap;
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

    /* ===== Medical Facility Modals ===== */
    .medical-facility-modal .modal-dialog {
        width: calc(100% - 12px);
        max-width: 1200px;
    }

    .medical-facility-modal .modal-content {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        line-height: 1.35;
    }

    .medical-facility-modal .modal-title {
        font-size: 18px;
        font-weight: 400;
    }

    .medical-facility-modal .nav-tabs {
        gap: 4px;
        margin-bottom: 16px !important;
    }

    .medical-facility-modal .nav-tabs .nav-link {
        padding: 10px 14px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.2;
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

     <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex flex-column gap-1">
            <h2 class="fw-bold mb-0">{{ $hospital->name }}</h2>
            <span class="fw-bold"><b>Global Classification:</b> {{ $hospital->facility_category }} | <b>Country Classification:</b> {{ $hospital->facility_level }}</span>
        </div>

        <div class="d-flex gap-2 ms-auto">
            <!-- Button 2 -->
            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-medical-facility-white.png') }}" style="width: 18px; height: 24px;">
                <small>Clinical</small>
            </a>

            <!-- Button 4 -->
            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>
            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                <small>Air Charter</small>
            </a>

            <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                <small>Police</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                <small>Embassies</small>
            </a>
        </div>
    </div>

     <div class="card mb-4 position-relative">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated / Verified {{ $hospital->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('hospitaldata.edit', $hospital->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>

<div class="row">
    <div class="col-sm-5">
        <div class="card">

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
                                        <small>Small Private Hospital</small>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

        </div>
    </div>
</div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-menu-medical-facility.png') }}" style="width: 24px; height: 24px;"> Clinical Services</div>
              <div class="card-body overflow-auto">
                <div class="row">
                <div class="col-sm-6">
                    <table class="table table-hover clinical-service-table">
                        <tr>
                            <td>Inpatient</td>
                            <td>{{ $hospital->inpatient_services }}</td>
                        </tr>
                        <tr>
                            <td>Outpatient</td>
                            <td>{{ $hospital->outpatient_services }}</td>
                        </tr>
                        <tr>
                            <td>24 hr ER</td>
                            <td>{{ $hospital->hour_emergency_services }}</td>
                        </tr>
                        <tr>
                            <td>Ambulance</td>
                            <td>{{ $hospital->ambulance }}</td>
                        </tr>
                        <tr>
                            <td>Helipad</td>
                            <td>{{ $hospital->helipad }}</td>
                        </tr>

                        @if (!empty($hospital->comments))
                        <tr>
                            <td>Note</td>
                            <td>{{ $hospital->comments }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td>ICU</td>
                            <td>{{ $hospital->icu }}</td>
                        </tr>
                        <tr>
                            <td>Medical</td>
                            <td>{{ $hospital->medical }}</td>
                        </tr>
                        <tr>
                            <td>Pediatric</td>
                            <td>{{ $hospital->pediatric }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table table-hover clinical-service-table">
                        <tr>
                            <td>Maternal</td>
                            <td>{{ $hospital->maternal }}</td>
                        </tr>
                        <tr>
                            <td>Dental</td>
                            <td>{{ $hospital->dental }}</td>
                        </tr>
                        <tr>
                            <td>Optical</td>
                            <td>{{ $hospital->optical }}</td>
                        </tr>
                        <tr>
                            <td>Integrated Outreach Clinic (IOC)</td>
                            <td>{{ $hospital->ioc }}</td>
                        </tr>
                        <tr>
                            <td>Laboratory</td>
                            <td>{{ $hospital->laboratory }}</td>
                        </tr>
                        <tr>
                            <td>Pharmacy</td>
                            <td>{{ $hospital->pharmacy }}</td>
                        </tr>
                        <tr>
                            <td>Medical Imaging</td>
                            <td>{{ $hospital->medical_imaging }}</td>
                        </tr>
                        <tr>
                            <td>Medical Student Training</td>
                            <td>{{ $hospital->medical_student_training }}</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                  <div class="card-header fw-bold"><img src="{{ asset('images/icon-medical-personel.png') }}" style="width: 32px; height: 24px;"> Medical Personnel</div>
             <div class="card-body overflow-auto">
                 <div class="row">
                <div class="col-sm-6">
                <table class="table table-hover clinical-service-table">
                    <tr>
                        <td>Doctors</td>
                        <td>{{ $hospital->doctors }}</td>
                    </tr>
                    <tr>
                        <td>Nurses</td>
                        <td>{{ $hospital->nurses }}</td>
                    </tr>
                    <tr>
                        <td>Dental Therapist</td>
                        <td>{{ $hospital->dental_therapist }}</td>
                    </tr>
                    <tr>
                        <td>Laboratory Assistants</td>
                        <td>{{ $hospital->laboratory_assistants }}</td>
                    </tr>
                    <tr>
                        <td>Community Health Workers/Orderlies</td>
                        <td>{{ $hospital->community_health }}</td>
                    </tr>
                </table>
                </div>
                <div class="col-sm-6">
                <table class="table table-hover clinical-service-table">
                    <tr>
                        <td>Health Inspectors</td>
                        <td>{{ $hospital->health_inspectors }}</td>
                    </tr>
                    <tr>
                        <td>Malaria Control Officers</td>
                        <td>{{ $hospital->malaria_control_officers ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Health Extension Officers</td>
                        <td>{{ $hospital->health_extention_officers }}</td>
                    </tr>
                    <tr>
                        <td>Casuals</td>
                        <td>{{ $hospital->casuals }}</td>
                    </tr>
                </table>
                </div>
                </div>
            </div>
            </div>

             <div class="card">
                <div class="card-body overflow-auto">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>{!! $hospital->medical_personel_disclaimer; !!}</p>
                        </div>
                    </div>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
