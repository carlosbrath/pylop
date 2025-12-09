<!-- Footer -->
<footer class="footer text-white pt-4 pb-2">
    <div class="container">
        <div class="row">
            <!-- Logo + Info -->
            <div class="col-md-6 mb-3 mb-md-0 d-flex gap-3 align-items-center">
                <div>
                    <a class=" d-flex align-items-center gap-2" href="{{ route('home') }}">
                        <img src=" {{ asset('/assets/img/public/logo.png') }}" alt="PMYLP" class="footer-logo">
                        {{-- <span class="fw-bold text-success" title="Prime Minister Youth Loan Program">PMYLP</span> --}}
                    </a>
                </div>
                <div>
                    <h5 class="fw-bold h1-heading">Prime Minister Youth Loan Program</h5>
                    <p style="font-size: 14px">
                        Empowering youth through entrepreneurship under the vision of the Prime Minister.
                    </p>
                </div>
            </div>

            <!-- Quick Links (Optional) -->
            <div class="col-md-3">
                <h6 class="fw-bold">Quick Links</h6>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('home') }}#about" class="text-white text-decoration-none">About</a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#eligibility"
                            class="text-white text-decoration-none">Eligibility</a>
                    </li>
                    <li>
                        <a href="{{ route('loan.application') }}" class="text-white text-decoration-none">Apply</a>
                    </li>
                    <li>
                        <a href="{{ route('track.application') }}" class="text-white text-decoration-none">Track</a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#faq" class="text-white text-decoration-none">FAQs</a>
                    </li>

                </ul>
            </div>

            <!-- Contact Info (Optional) -->
            <div class="col-md-3">
                <h6 class="fw-bold">Contact</h6>
                <ul class="list-unstyled">
                    {{-- <li><i class="bi bi-envelope me-1"></i> info@ajkloans.gov.pk</li> --}}
                    <li><a href="tel:05822 920812"><i class="bi bi-telephone me-1"></i>05822 920812 </a></li>
                    <li><a href="tel:05822 920813"><i class="bi bi-telephone me-1"></i> 05822 920813 </a></li>
                    <li><i class="bi bi-geo-alt me-1"></i> Muzaffarabad, AJK</li>
                </ul>
            </div>
        </div>

        <hr class="border-light" />

        <div class="text-center small">
            &copy; 2025 <a href="https://itb.ajk.gov.pk/" class="text-info">AJ&K Information Technology Board</a>.
            Developed with 💚 by
            <a href="https://itb.ajk.gov.pk/" class="text-info"><strong>IT Board Development Team</strong></a>.
        </div>
    </div>
</footer>
<!-- Popup Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-success ">
            <div class="modal-header bg-success text-white">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <h5 class="modal-title urdu-text" id="announcementLabel" dir="rtl">📢 اہم اطلاع</h5>

            <div class="modal-body urdu-text text-justify" dir="rtl" style="line-height: 2; font-size: 1rem;">
                <p>
                    آزاد کشمیر سمال انڈسٹریز کارپوریشن درخواست قرضہ فارم کا ابتدائی سطح پر جائزہ لیکر بینک آف آزاد جموں
                    و کشمیر کو ارسال کرے گی۔
                    درخواست دہندگان بینک آف آزاد جموں و کشمیر کی قریب ترین برانچ سے رابطہ کریں۔
                    قرضہ پہلے آئے پہلے پائے کی بنیاد پر دیا جائے گا۔
                </p>
                <p>
                    آن لائن درخواست کے علاؤہ قرضہ فارم بینک آف آزاد جموں و کشمیر کی تمام برانچز سے حاصل کیے جا سکتے ہیں۔
                    بعد از تکمیل قرضہ فارم مندرجہ ذیل پتوں پر ارسال کیے جائیں:
                </p>

                <ul class="list-unstyled">
                    <li>
                        <strong><i class="bi bi-geo-alt-fill text-danger"></i> مظفرآباد ڈویژن:</strong>
                        ڈپٹی ڈائریکٹر ایڈمن، سمال انڈسٹریز باالمقابل ڈسٹرکٹ ہیڈ کوارٹر کمپلیکس اولڈ سیکریٹریٹ،
                        مظفرآباد<br>
                        <i class="bi bi-telephone-fill text-success"></i> <strong>05822-920812</strong>
                    </li>
                    <li class="mt-3">
                        <strong><i class="bi bi-geo-alt-fill text-danger"></i> پونچھ ڈویژن:</strong>
                        ڈویژنل آفیسر، سمال انڈسٹریز نزد ووکیشنل ٹریننگ انسٹی ٹیوٹ AJKTEVTA، راولاکوٹ<br>
                        <i class="bi bi-telephone-fill text-success"></i> <strong>0344-5529532</strong>
                    </li>
                    <li class="mt-3">
                        <strong><i class="bi bi-geo-alt-fill text-danger"></i> میرپور ڈویژن:</strong>
                        ڈویژنل آفیسر، سمال انڈسٹریز D-I اولڈ انڈسٹریل ایریا، میرپور<br>
                        <i class="bi bi-telephone-fill text-success"></i> <strong>0343-5050388</strong>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ asset('assets/img/public/Front.webp') }}" alt="Image" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>
