<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'company_name_ar' => 'مدرسة مزون',
            'company_name_en' => 'Mazoon soft',
            'phone_code' => '966',
            'tax_percentage' => 15.00,

            'contract_terms_ar' => "
            <h3>المادة (3): مدة العقد</h3>
            <p>يسري هذا العقد لمدة عام دراسي واحد ويُجدد تلقائياً ما لم يخطر أحد الطرفين الآخر برغبته في إنهاء التعاقد قبل إنهاء العام الدراسي بمدة لا تقل عن 15 يوم.</p>

            <h3>المادة (4): الانسحاب واسترداد الرسوم</h3>
            <p>في حال انسحاب الطالب قبل بداية الدراسة يُسترد كامل المبلغ. بعد بدء الدراسة تُحتسب الرسوم بناءً على الفصل الدراسي وقوانين وزارة التعليم، ولا يُعاد أي مبلغ عن الفترة الماضية. لا يُسترد المبلغ بعد مرور أكثر من نصف الفصل الدراسي.</p>

            <h3>المادة (5): التأخر أو الامتناع عن سداد الرسوم الدراسية</h3>
            <p>يلتزم ولي الأمر بسداد الرسوم الدراسية في المواعيد المحددة حسب ما ورد في المادة (3) من هذا العقد. في حال تأخر السداد لأكثر من 15 يومًا من تاريخ الاستحقاق دون عذر مقبول، يحق للمدرسة اتخاذ أي من الإجراءات التالية:</p>
            <ul>
            <li>إيقاف الخدمات التعليمية مؤقتًا (مثل حجب النتائج أو منع الدخول إلى المنصة التعليمية).</li>
            <li>تعليق حضور الطالب حضوريًا أو إلكترونيًا حتى يتم السداد.</li>
            <li>عدم إصدار الشهادات أو إخلاء الطرف.</li>
            <li>رفض إعادة تسجيل الطالب للعام التالي.</li>
            </ul>
            <p>إذا استمر عدم السداد لأكثر من 30 يومًا، تعتبر المدرسة في حلٍّ من التزاماتها تجاه استمرار الطالب، ويحق لها:</p>
            <ul>
            <li>إلغاء قيد الطالب</li>
            <li>المطالبة بكامل الرسوم المستحقة</li>
            <li>اتخاذ الإجراءات القانونية اللازمة ضد ولي الأمر لتحصيل المستحقات، بما في ذلك الرفع إلى الجهات المختصة أو الجهات القضائية.</li>
            </ul>
            <p>جميع هذه الإجراءات قائمة على الأنظمة والتعليمات المعتمدة من وزارة التعليم والأنظمة المالية في المملكة العربية السعودية.</p>

            <h3>المادة (6): الزي المدرسي</h3>
            <p>يلتزم الطالب/ـة بارتداء الزي المدرسي المعتمد من المدرسة يوميًا، والمحافظة عليه نظيفًا ومرتبًا. يتم تسليم ولي الأمر تفاصيل الزي المدرسي في بداية العام الدراسي، وتشمل:</p>
            <ul>
            <li>اللون</li>
            <li>الشكل</li>
            <li>أماكن الشراء أو التصنيع المعتمدة (إن وجدت)</li>
            </ul>
            <p>يُمنع ارتداء أي زي غير معتمد أو معدل أو مزين بشعارات غير رسمية. يحق للمدرسة اتخاذ الإجراء المناسب في حال تكرار عدم الالتزام بالزي، بعد إنذار ولي الأمر.</p>

            <h3>المادة (7): الالتزامات الأكاديمية والسلوكية</h3>
            <p>يلتزم ولي الأمر بمتابعة أداء وسلوك الطالب/ة، والتعاون مع المدرسة. تلتزم المدرسة بتوفير بيئة تعليمية آمنة ومنظمة. في حال وجود مخالفات سلوكية أو أكاديمية، يُخطر ولي الأمر رسميًا.</p>

            <h3>المادة (8): الحضور والغياب</h3>
            <p>الغياب المتكرر دون عذر قد يعرض الطالب للحرمان أو الإنذار الأكاديمي. يُلزم الطالب بالانتظام في الدوام والالتزام بالزي المدرسي.</p>

            <h3>المادة (9): النقل أو إخلاء الطرف</h3>
            <p>يتم إخلاء طرف الطالب بعد تسوية جميع المستحقات المالية. لا يتم إصدار الشهادات أو نتائج نهاية العام إلا بعد إكمال الالتزامات.</p>

            <h3>المادة (10): شروط التسجيل للطلاب غير السعوديين</h3>
            <p>يشترط لقبول الطلاب غير السعوديين توفر إقامة نظامية سارية المفعول، ويتم تحديثها بشكل دوري. يلتزم ولي الأمر بتزويد المدرسة بصورة من الإقامة وجواز السفر، وتحديثها فور التجديد. في حال انتهاء الإقامة وعدم تجديدها خلال 30 يومًا من تاريخ الانتهاء، يحق للمدرسة إيقاف الطالب عن الدراسة حتى يتم التجديد. يجب أن تكون إقامة الطالب على كفالة ولي أمره مباشرة. لا تتحمل المدرسة أي مسؤولية قانونية تجاه تأشيرات الطالب أو مخالفات الإقامة.</p>

            <h3>المادة (11): الحالات الطارئة</h3>
            <p>في حال وقوع ظرف قهري (مثل: جائحة، كوارث طبيعية، تعليمات وزارية) فإن المدرسة تحتفظ بحقها في تعديل نظام الدراسة دون استرداد الرسوم، بما يتماشى مع الأنظمة.</p>

            <h3>المادة (12): أحكام عامة</h3>
            <p>هذا العقد ملزم للطرفين طوال مدته. أي تعديل لا يكون نافذًا إلا بموافقة الطرفين خطيًا. تختص المحاكم السعودية في حال حدوث خلاف لا قدر الله.</p>

            <h3>المادة (13): التلف أو التخريب</h3>
            <p>يلتزم الطالب/ـة بالحفاظ على ممتلكات المدرسة ومرافقها من فصول، مختبرات، أجهزة، أثاث، كتب، وغيرها. في حال حدوث تلف أو تخريب متعمد من الطالب، يتحمل ولي الأمر المسؤولية الكاملة عن إصلاح أو تعويض ما تم إتلافه. يتم تحديد قيمة التعويض من قبل إدارة المدرسة حسب تقدير الضرر. في حال تكرار المخالفة، يحق للمدرسة اتخاذ الإجراءات التأديبية المناسبة، والتي قد تشمل الإنذار الخطي، الحرمان المؤقت، أو نقل الطالب.</p>

            <h3>المادة (14): التقصير الدراسي أو إساءة السلوك</h3>
            <p>تلتزم المدرسة بمتابعة مستوى الطالب/ـة الدراسي والسلوكي، وتقديم الدعم والتوجيه اللازم. في حال التقصير الأكاديمي المتكرر رغم المحاولات والإشعارات الموجهة لولي الأمر، تحتفظ المدرسة بحقها في:</p>
            <ul>
            <li>عدم قبول تسجيل الطالب للعام الدراسي التالي</li>
            <li>أو اقتراح نقله إلى مدرسة أخرى تناسب قدراته</li>
            </ul>
            <p>في حال ارتكاب الطالب مخالفات سلوكية جسيمة أو متكررة (مثل: الاعتداء، الشتم، التخريب، التنمر...)، بعد توجيه إنذارات مكتوبة، يحق للمدرسة:</p>
            <ul>
            <li>فصل الطالب فصلاً مؤقتًا أو دائمًا، حسب لائحة السلوك والمواظبة المعتمدة من وزارة التعليم</li>
            <li>ويُخطر ولي الأمر رسميًا بكافة الإجراءات</li>
            </ul>

            <h3>المادة (15): الالتزام بالتسجيل في الوقت المحدد</h3>
            <p>يلتزم ولي الأمر بإتمام إجراءات التسجيل الرسمية للطالب/ـة خلال الفترة التي تعلنها المدرسة. تشمل إجراءات التسجيل:</p>
            <ul>
            <li>تعبئة النماذج المطلوبة</li>
            <li>تسليم الوثائق الرسمية</li>
            <li>دفع الرسوم الدراسية أو الدفعة الأولى</li>
            </ul>
            <p>في حال تجاوز المدة المحددة للتسجيل دون استكمال الإجراءات، تحتفظ المدرسة بحقها في:</p>
            <ul>
            <li>عدم ضمان حجز مقعد للطالب</li>
            <li>أو تحويله إلى قائمة الانتظار</li>
            </ul>
            <p>تُعطى الأولوية في القبول للطلاب الذين أتمّوا التسجيل مبكرًا ووفق الأنظمة.</p>

            <h3>المادة (16): التقييم القبلي قبل التسجيل</h3>
            <p>تحتفظ المدرسة بحقها في إجراء اختبار قبلي أو مقابلة شخصية للطالب/ـة قبل القبول النهائي، خاصة في حالات:</p>
            <ul>
            <li>النقل من مدرسة أخرى</li>
            <li>التقديم للصفوف العليا</li>
            <li>ضعف في المستندات أو علامات غير واضحة</li>
            </ul>
            <p>تهدف هذه الإجراءات إلى:</p>
            <ul>
            <li>تحديد مستوى الطالب الأكاديمي</li>
            <li>تقييم مهاراته وسلوكه العام</li>
            <li>ضمان توافقه مع بيئة المدرسة ومستواها</li>
            </ul>
            <p>يُبلَّغ ولي الأمر بنتائج التقييم، ويُعد القبول مبدئيًا حتى اجتياز التقييم بنجاح. في حال عدم اجتياز التقييم، يحق للمدرسة الاعتذار عن القبول، أو اقتراح صف أو مرحلة مناسبة.</p>

            <h3>المادة (17): سياسة سحب الملف</h3>
            <p>يحق لولي الأمر طلب سحب ملف الطالب/ـة في أي وقت خلال العام الدراسي، شريطة تقديم طلب خطي أو إلكتروني رسمي لإدارة المدرسة. يشترط لسحب الملف ما يلي:</p>
            <ul>
            <li>تسوية كافة الرسوم والمستحقات المالية</li>
            <li>إعادة جميع الكتب والممتلكات المدرسية المسلّمة للطالب</li>
            <li>توقيع نموذج إخلاء الطرف من جميع أقسام المدرسة (المالية – الأكاديمية – المكتبة – شؤون الطلاب)</li>
            </ul>
            <p>يتم إصدار إخلاء الطرف وتسليم الملف خلال مدة أقصاها (3 – 5) أيام عمل بعد اكتمال الشروط أعلاه. في حال الانسحاب خلال الفصل الدراسي، تطبق سياسة الاسترداد الموضحة في المادة (4). لا تُمنح الشهادات أو الوثائق الرسمية إلا بعد إتمام عملية سحب الملف حسب الأنظمة.</p>

            <h3>المادة (18): وسائل التواصل مع ولي أمر الطالب</h3>
            <p>تعتمد المدرسة وسائل التواصل الرسمية التالية لإبلاغ ولي الأمر بجميع المستجدات الأكاديمية والسلوكية والإدارية:</p>
            <ul>
            <li>الرسائل النصية (SMS)</li>
            <li>الاتصال الهاتفي المباشر</li>
            <li>تطبيقات المدرسة (إن وجدت)</li>
            <li>البريد الإلكتروني</li>
            </ul>
            <p>يلتزم ولي الأمر بتحديث بيانات التواصل (رقم الجوال – البريد الإلكتروني) عند أي تغيير. تعتبر الرسائل أو الإشعارات المرسلة عبر الوسائل المذكورة أعلاه بلاغًا رسميًا ومعتمدًا. في حال تعذر الوصول لولي الأمر، يحق للمدرسة اتخاذ ما تراه مناسبًا من إجراءات تحفظ سلامة الطالب وضمان سير العملية التعليمية.</p>

            <p><strong>وبذلك يكون الطرفان قد قرآ جميع مواد هذا العقد وفهماها ووافقا عليها، وتم التوقيع من قبلهما بكامل الإرادة والرضا، والعمل بما جاء فيه.</strong></p>
            <p>تم التوقيع في مدينة: جدة</p>
            <p>بتاريخ:     /    /   14هـ</p>
            <p>الموافق:     /    /    20م</p>",
            'contract_terms_en' => "
            <h3>Article (3): Contract Duration</h3>
            <p>This contract is valid for one academic year and will be automatically renewed unless either party notifies the other of its intention to terminate the contract at least 15 days before the end of the academic year.</p>

            <h3>Article (4): Withdrawal and Refund Policy</h3>
            <p>If the student withdraws before the start of the academic year, the full amount is refunded. After the academic year begins, fees are calculated based on the semester and Ministry of Education regulations, and no refunds will be issued for past periods. No amount is refunded after more than half of the semester has passed.</p>

            <h3>Article (5): Delay or Failure to Pay Tuition Fees</h3>
            <p>The guardian is obligated to pay tuition fees on the scheduled dates as stated in Article (3) of this contract. If payment is delayed for more than 15 days without an acceptable excuse, the school has the right to take any of the following actions:</p>
            <ul>
                <li>Temporarily suspend educational services (such as withholding results or blocking access to the online platform).</li>
                <li>Suspend student attendance physically or electronically until payment is made.</li>
                <li>Withhold certificates or clearance forms.</li>
                <li>Refuse to re-enroll the student for the next academic year.</li>
            </ul>
            <p>If payment is delayed for more than 30 days, the school is no longer obligated to continue serving the student and has the right to:</p>
            <ul>
                <li>Cancel the student’s enrollment.</li>
                <li>Demand full outstanding tuition fees.</li>
                <li>Take legal action against the guardian to recover dues, including involving relevant authorities or the judiciary.</li>
            </ul>
            <p>All these actions are in accordance with the regulations and instructions approved by the Ministry of Education and financial systems in the Kingdom of Saudi Arabia.</p>

            <h3>Article (6): School Uniform</h3>
            <p>The student is required to wear the school-approved uniform daily and keep it clean and neat. Details of the uniform will be provided to the guardian at the beginning of the academic year, including:</p>
            <ul>
                <li>Color</li>
                <li>Style</li>
                <li>Approved purchasing or tailoring locations (if any)</li>
            </ul>
            <p>Wearing unauthorized, modified, or decorated uniforms with unofficial logos is prohibited. The school reserves the right to take appropriate action after warning the guardian in case of repeated violations.</p>

            <h3>Article (7): Academic and Behavioral Responsibilities</h3>
            <p>The guardian is responsible for monitoring the student's performance and behavior and cooperating with the school. The school commits to providing a safe and organized educational environment. In case of academic or behavioral violations, the guardian will be formally notified.</p>

            <h3>Article (8): Attendance and Absence</h3>
            <p>Frequent unexcused absences may lead to disciplinary action or academic warning. The student must attend regularly and adhere to the school uniform policy.</p>

            <h3>Article (9): Transfer or Clearance</h3>
            <p>Clearance is granted only after settling all financial dues. Certificates and year-end results will not be issued until obligations are fulfilled.</p>

            <h3>Article (10): Admission Requirements for Non-Saudi Students</h3>
            <p>Non-Saudi students must have a valid residency permit, which must be updated regularly. The guardian is responsible for providing copies of the residency and passport and renewing them promptly. If the residency expires and is not renewed within 30 days, the school has the right to suspend the student until renewal. The student must be under the direct sponsorship of the guardian. The school holds no legal responsibility for visa or residency violations.</p>

            <h3>Article (11): Emergency Situations</h3>
            <p>In cases of force majeure (e.g., pandemic, natural disaster, ministerial instructions), the school reserves the right to modify the learning system without refund, in accordance with applicable laws.</p>

            <h3>Article (12): General Provisions</h3>
            <p>This contract is binding on both parties throughout its duration. No modification is valid unless agreed upon in writing by both parties. Saudi courts shall have jurisdiction in case of any dispute.</p>

            <h3>Article (13): Damage or Vandalism</h3>
            <p>The student must preserve school property including classrooms, labs, devices, furniture, books, and other facilities. In case of deliberate damage or vandalism, the guardian will be fully responsible for the repair or compensation as determined by the school administration. Repeated violations may lead to disciplinary action such as written warnings, temporary suspension, or transfer of the student.</p>

            <h3>Article (14): Academic Underperformance or Misbehavior</h3>
            <p>The school commits to monitoring and supporting the student's academic and behavioral development. In the case of repeated academic failure despite efforts and notifications to the guardian, the school reserves the right to:</p>
            <ul>
                <li>Decline re-enrollment of the student for the following academic year.</li>
                <li>Recommend transferring the student to another school more suited to their capabilities.</li>
            </ul>
            <p>In case of severe or repeated behavioral violations (e.g., assault, insults, vandalism, bullying), after written warnings, the school may:</p>
            <ul>
                <li>Temporarily or permanently expel the student according to the Ministry of Education’s discipline policy.</li>
                <li>Formally notify the guardian of all actions taken.</li>
            </ul>

            <h3>Article (15): Timely Registration Commitment</h3>
            <p>The guardian must complete the student’s registration procedures within the timeline announced by the school, including:</p>
            <ul>
                <li>Filling out required forms</li>
                <li>Submitting official documents</li>
                <li>Paying tuition or first installment</li>
            </ul>
            <p>If the deadline is missed without completing the process, the school reserves the right to:</p>
            <ul>
                <li>Not guarantee the student’s seat</li>
                <li>Move the student to a waiting list</li>
            </ul>
            <p>Priority is given to students who complete registration early and according to the rules.</p>

            <h3>Article (16): Pre-Admission Evaluation</h3>
            <p>The school reserves the right to conduct a pre-admission assessment or interview, especially in cases of:</p>
            <ul>
                <li>Transfers from another school</li>
                <li>Applications to higher grades</li>
                <li>Incomplete or unclear documentation</li>
            </ul>
            <p>These steps aim to:</p>
            <ul>
                <li>Determine the student’s academic level</li>
                <li>Assess general skills and behavior</li>
                <li>Ensure the student aligns with the school’s environment and standards</li>
            </ul>
            <p>The guardian will be informed of the assessment results. Admission is considered provisional until the student passes the evaluation. If not passed, the school may decline admission or recommend a suitable level.</p>

            <h3>Article (17): File Withdrawal Policy</h3>
            <p>The guardian may request the student’s file withdrawal at any time during the academic year by submitting a formal written or electronic request to the school administration. Conditions for file withdrawal include:</p>
            <ul>
                <li>Settling all financial dues</li>
                <li>Returning all borrowed school materials</li>
                <li>Completing clearance forms from all school departments (finance, academic, library, student affairs)</li>
            </ul>
            <p>The clearance process and file release will be completed within 3–5 working days after fulfilling the above conditions. In case of mid-semester withdrawal, the refund policy stated in Article (4) applies. Certificates or official documents will only be issued after completing the file withdrawal process.</p>

            <h3>Article (18): Communication with the Student’s Guardian</h3>
            <p>The school uses the following official channels to communicate academic, behavioral, and administrative updates:</p>
            <ul>
                <li>Text messages (SMS)</li>
                <li>Direct phone calls</li>
                <li>School applications (if available)</li>
                <li>Email</li>
            </ul>
            <p>The guardian must update contact information (mobile number and email) in case of any changes. All communications via these channels are considered official notifications. If the school is unable to reach the guardian, it reserves the right to take appropriate measures to ensure the student’s safety and continuity of education.</p>

            <p><strong>Both parties hereby declare that they have read, understood, and agreed to all articles of this contract and have signed it willingly and with full consent.</strong></p>
            <p>Signed in: Jeddah</p>
            <p>Date:     /    /   AH</p>
            <p>Corresponding to:     /    /    AD</p>
            ",
        ]);
    }
}
