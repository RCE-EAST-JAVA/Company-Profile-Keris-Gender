<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\HeroPhoto;
use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        // 1. Admin User
        $user = User::firstOrCreate(
            ['email' => 'director@kerisgender.org'],
            [
                'name' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Staff (Researchers & Research Assistants)
        Staff::truncate();

        $staffMembers = [
            [
                'name' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'role' => 'Director of Research & Critical Theory',
                'category' => 'Researcher',
                'expertise' => 'Intersectional Theory, Public Policy, Stratification',
                'description' => "Two decades deconstructing institutional patriarchy, domestic care burden, and formulating intersectional public policies across Southeast Asian constitutional regimes. Leading fellow for comparative constitutional gender jurisprudence and founding chair of Center for Gender and International Relations Studies (GInRe).\n\nHer scholarship interrogates structural violence embedded in economic policies and legislative drafting, with particular focus on social reproduction and agrarian transitions.",
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop',
                'email' => 'amanda.dewi@kerisgender.org',
                'linkedin' => 'https://linkedin.com/in/amandadewi',
                'sort_order' => 1,
            ],
            [
                'name' => 'Dr. Hendra Wibowo, S.H., LL.M.',
                'role' => 'Head of Law & Human Rights Division',
                'category' => 'Researcher',
                'expertise' => 'Judicial Reform, Human Rights, Legal Aid Systems',
                'description' => "Leading legal jurisprudence on criminal code reforms, bodily autonomy protection, and procedural violence within trial court proceedings and appellate advocacy across Indonesian and ASEAN court systems.\n\nDr. Wibowo regularly serves as expert witness in landmark constitutional reviews on sexual violence legislation and digital protections for marginalized communities.",
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop',
                'email' => 'hendra.wibowo@kerisgender.org',
                'linkedin' => 'https://linkedin.com/in/hendrawibowo',
                'sort_order' => 2,
            ],
            [
                'name' => 'Dr. Kartika Rahayu, M.Sc.',
                'role' => 'Senior Fellow in Political Ecology',
                'category' => 'Researcher',
                'expertise' => 'Political Ecology, Climate Justice, Indigenous Rights',
                'description' => "Investigating disproportionate climate impacts on traditional coastal fisherwomen and constructing participatory adaptation taxonomies across insular archipelagos.\n\nHer extensive ethnographic fieldwork spans Java's north coast, Sulawesi nickel corridors, and East Nusa Tenggara customary fishing commons.",
                'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=800&auto=format&fit=crop',
                'email' => 'kartika.rahayu@kerisgender.org',
                'linkedin' => 'https://linkedin.com/in/kartikarahayu',
                'sort_order' => 3,
            ],
            [
                'name' => 'Farhan Maulana, S.Sos.',
                'role' => 'Lead Field Ethnographer & Community Liaison',
                'category' => 'Research Assistant',
                'expertise' => 'Participatory Mapping, Agrarian Conflict, Oral History',
                'description' => "Facilitating multi-sited ethnographic field immersion with peasant federations in Central Java and frontline mining communities in eastern islands.",
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&auto=format&fit=crop',
                'email' => 'farhan.m@kerisgender.org',
                'linkedin' => 'https://linkedin.com/in/farhanmaulana',
                'sort_order' => 4,
            ],
            [
                'name' => 'Nadia Larasati, S.H.',
                'role' => 'Junior Legal Researcher & Policy Analyst',
                'category' => 'Research Assistant',
                'expertise' => 'TFGBV Documentation, Victim Advocacy, Constitutional Review',
                'description' => "Managing empirical case law tracking on digital gender-based violence, algorithmic harassment, and judicial procedural safeguards.",
                'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=800&auto=format&fit=crop',
                'email' => 'nadia.larasati@kerisgender.org',
                'linkedin' => 'https://linkedin.com/in/nadialarasati',
                'sort_order' => 5,
            ],
            [
                'name' => 'Dian Pratiwi, M.A.',
                'role' => 'Quantitative Data Analyst & Survey Coordinator',
                'category' => 'Research Assistant',
                'expertise' => 'Gender-Responsive Budgeting, Microdata Modeling, Survey Methodology',
                'description' => "Overseeing subnational public expenditure tracking data and developing quantitative vulnerability indices for regional development agencies.",
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=800&auto=format&fit=crop',
                'email' => 'dian.pratiwi@kerisgender.org',
                'linkedin' => 'https://linkedin.com/in/dianpratiwi',
                'sort_order' => 6,
            ],
        ];

        foreach ($staffMembers as $staff) {
            Staff::create($staff);
        }

        // 3. Articles (Publications, Journals, Monographs, Policy Briefs, Reports)
        Article::truncate();

        $articles = [
            [
                'title' => 'Intersectional Vulnerability: Climate Crisis and Economic Resilience among Coastal Women in Java',
                'slug' => 'intersectional-vulnerability-climate-crisis-and-economic-resilience-among-coastal-women-in-java',
                'category' => 'Book & Module',
                'thumbnail' => 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=1200&auto=format&fit=crop',
                'excerpt' => 'A multi-sited quantitative and ethnographic investigation across 1,200 coastal households analyzing salinization, extreme tidal surges, and the unrecognized burden of reproductive labor. Offers actionable legal remedies for regional adaptation grants.',
                'body' => "## Executive Summary\n\nThe climate emergency along the northern coastline of Java (Pantura) represents not merely an environmental disruption, but a compounded crisis of social reproduction, spatial displacement, and systemic gender inequality. This 412-page peer-reviewed monograph documents the lived experiences of over 1,200 households across Demak, Pekalongan, and Semarang regencies.\n\n### Key Findings\n1. **Unrecognized Care Work Surge**: Women spend an average of 5.8 additional hours daily mitigating saltwater intrusion, securing drinkable freshwater, and repairing flooded dwelling foundations.\n2. **Financial Precarity**: Microcredit and informal cooperative debts have grown by 34% among female fish-sorters and crab shellers due to reduced seasonal catch yields.\n3. **Policy Deficit**: Less than 4% of subnational disaster mitigation funds allocate direct cash transfers or adaptation assistance specifically targeted at female-headed coastal households.\n\n### Methodological Rigor\nOur research deployed mixed methodologies comprising satellite inundation modeling, participatory household time-use logs, and deep feminist ethnographic testimony collected over a 24-month field deployment.",
                'author' => 'Dr. Kartika Rahayu, M.Sc., Prof. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Climate Justice, Coastal Labor, Vulnerability Index, Ecological Economics',
                'published_at' => '2025-01-15 09:00:00',
                'is_pinned' => true,
            ],
            [
                'title' => 'Ethnographic Study: Indigenous Women’s Resistance to Extractive Concessions',
                'slug' => 'ethnographic-study-indigenous-womens-resistance-to-extractive-concessions',
                'category' => 'Journal Article',
                'thumbnail' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Documenting spiritual territoriality, non-violent barricades, and indigenous legal jurisprudence among customary communities facing nickel mining expansions in Halmahera.',
                'body' => "## Introduction\n\nAs the global energy transition accelerates critical mineral extraction, indigenous territories across eastern Indonesia face unprecedented industrial encroachment. Customary women hold sacred custodial responsibilities over potable spring sources, sago groves, and medicinal river basins.\n\n### Spatial Resistance\nThrough physical blockades, cultural ritual invocations, and regional administrative appeals, indigenous women have reclaimed ancestral riverbanks against unauthorized nickel smelting tailings disposals.",
                'author' => 'Dr. Kartika Rahayu, M.Sc.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Agrarian Studies, Indigenous Rights, Political Ecology, Nickel Corridor',
                'published_at' => '2024-08-10 10:30:00',
                'is_pinned' => false,
            ],
            [
                'title' => 'Gender-Responsive Public Budgeting: Curriculum & Training Module',
                'slug' => 'gender-responsive-public-budgeting-curriculum-and-training-module',
                'category' => 'Book & Module',
                'thumbnail' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'A 258-page standardized pedagogical module and practical manuals designed for regional government planners and civil society budget auditors.',
                'body' => "## Overview\n\nThis curriculum provides structured toolkits for civil servants and civic budget auditors to operationalize gender analysis pathways within regional revenue allocation (APBD).\n\n### Core Chapters\n- Chapter 1: Macro-Fiscal Frameworks and Substantive Equality\n- Chapter 2: Gender Budget Statement (GBS) Formulation & Auditing\n- Chapter 3: Participatory Public Consultation Frameworks\n- Chapter 4: Key Performance Indicators for Marginalized Inclusion",
                'author' => 'Keris Training Directorate',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Public Policy, Fiscal Reform, Local Governance, APBD Tracking',
                'published_at' => '2024-09-01 08:00:00',
                'is_pinned' => false,
            ],
            [
                'title' => 'Revisiting Women’s Political Representation in the 2024 General Elections',
                'slug' => 'revisiting-womens-political-representation-in-the-2024-general-elections',
                'category' => 'Journal Article',
                'thumbnail' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Empirical inquiry into candidate placement dynamics, zippered quota enforcement loopholes, and campaign financing barriers across 20 provincial assemblies.',
                'body' => "## Abstract\n\nDespite statutory affirmative quotas mandating 30% female candidacy in legislative rosters, the 2024 general election demonstrated persistent systemic roadblocks. This study reveals strategic gerrymandering of female candidates to non-competitive ballot positions and severe financial disparity in campaign donor networks.",
                'author' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Electoral Governance, Affirmative Action, Legislative Quotas, Political Sociology',
                'published_at' => '2024-06-18 14:00:00',
                'is_pinned' => false,
            ],
            [
                'title' => 'Comprehensive Legal Reforms on Technology-Facilitated Gender-Based Violence (TFGBV)',
                'slug' => 'comprehensive-legal-reforms-on-technology-facilitated-gender-based-violence',
                'category' => 'Policy Brief',
                'thumbnail' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Synthesizing evidentiary thresholds, encryption protocols, and non-consensual deepfake provisions for parliamentary legislative amendment.',
                'body' => "## Policy Problem Statement\n\nThe explosive proliferation of synthetic media, algorithmic doxxing, and non-consensual sexual image generation has outpaced prevailing provisions in the ITE Law and the TPKS Law. Victims face severe procedural barriers, victim-blaming evidentiary standards, and lack of immediate digital takedown mechanisms.\n\n### Legislative Recommendations\n1. Enact emergency civil restraining orders compelling immediate platform content preservation and removal within 6 hours of verified victim complaint.\n2. Shift burden of proof regarding digital chain-of-custody away from individual survivors toward specialized cyber units.\n3. Establish state-funded psycho-legal assistance funds for digital harassment survivors.",
                'author' => 'Dr. Hendra Wibowo, S.H., LL.M.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'National Policy Priority, Digital Rights, TFGBV, Criminal Law Reform',
                'published_at' => '2024-07-22 11:15:00',
                'is_pinned' => true,
            ],
            [
                'title' => 'Maternal and Reproductive Health Accessibility in Remote Island Territories',
                'slug' => 'maternal-and-reproductive-health-accessibility-in-remote-island-territories',
                'category' => 'Annual Report',
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Synthesizing 4 years of maritime ambulance transit data, community clinic midwife capacity, and essential prenatal supply chains in eastern archipelagic districts.',
                'body' => "## Key Highlights\n\nThis annual report audits maternal health infrastructure across 42 small-island clusters in Maluku and NTT. Our findings highlight how weather-dependent maritime transit leads to emergency obstetric delays, advocating for decentralized solar-powered clinics and helicopter evacuation corridors.",
                'author' => 'Health Equity Cluster',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Reproductive Justice, Remote Territories, Healthcare Infrastructure, Maritime Logistics',
                'published_at' => '2024-05-14 09:30:00',
                'is_pinned' => false,
            ],
            [
                'title' => 'Power Dynamics and Unpaid Care Burden in Post-Disaster Central Indonesia',
                'slug' => 'power-dynamics-and-unpaid-care-burden-in-post-disaster-central-indonesia',
                'category' => 'Journal Article',
                'thumbnail' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Drawing on 18 months of ethnographic data in Palu and Cianjur, examining how post-disaster reconstruction models systematically ignore gendered domestic reproduction burdens.',
                'body' => "## Abstract & Field Context\n\nDisaster recovery plans conventionally prioritize physical infrastructure—roads, seawalls, and commercial plazas—while ignoring the social reproductive infrastructure maintained almost exclusively by displaced women in temporary shelter settlements.\n\nOur ethnographic inquiry details the acute spatial vulnerabilities, increased domestic care burdens, and exclusion of women from reconstruction decision-making councils.",
                'author' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Disaster Recovery, Unpaid Care Work, Social Protection, Feminist Ethnography',
                'published_at' => '2024-11-05 13:00:00',
                'is_pinned' => true,
            ],
            [
                'title' => 'Legal Protections for Domestic Workers in Higher Education Institutions',
                'slug' => 'legal-protections-for-domestic-workers-in-higher-education-institutions',
                'category' => 'Policy Brief',
                'thumbnail' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Evaluating regulatory voids and contractual precarity among outsourced maintenance, sanitation, and cafeteria staff across state and private university campuses.',
                'body' => "## Policy Brief Summary\n\nUniversity campuses frequently claim academic ethical leadership while contracting third-party service bureaus that violate baseline labor rights for domestic, janitorial, and cafeteria personnel. This policy brief proposes standard academic labor dignity pacts and direct dispute resolution mechanisms.",
                'author' => 'Dr. Hendra Wibowo, S.H., LL.M.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Labor Law, Precarious Work, Decent Work, Campus Governance',
                'published_at' => '2024-10-12 16:45:00',
                'is_pinned' => false,
            ],
            [
                'title' => 'Campus Safety Laws: Gender-Based Violence Taskforce Governance',
                'slug' => 'campus-safety-laws-gender-based-violence-taskforce-governance',
                'category' => 'Policy Brief',
                'thumbnail' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Auditing institutional compliance with Permendikbudristek 30/2021 and assessing independent funding mechanisms for university grievance committees.',
                'body' => "## Policy Assessment\n\nIndependent operational audits across 35 university campuses revealed that 68% of task forces (Satgas PPKS) lack independent operational budgets and institutional legal immunity. We recommend ring-fenced national accreditation mandates and dedicated victim advocacy trust funds.",
                'author' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Higher Education, PPKS, Safety Governance, Student Protection',
                'published_at' => '2024-08-28 10:00:00',
                'is_pinned' => false,
            ],
            [
                'title' => 'Agrarian Dispossession and Women Peasants in the Nickel Corridor',
                'slug' => 'agrarian-dispossession-and-women-peasants-in-the-nickel-corridor',
                'category' => 'Policy Brief',
                'thumbnail' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?q=80&w=800&auto=format&fit=crop',
                'excerpt' => 'Impact assessment of nickel smelter expansion on freshwater contamination and indigenous subsistence agricultural livelihoods.',
                'body' => "## Executive Summary\n\nIndustrial nickel processing in Central and Southeast Sulawesi has severely impacted inland freshwater resources essential for subsistence women farmers. This brief calls for binding social-ecological impact guarantees and immediate community water restoration.",
                'author' => 'Dr. Kartika Rahayu, M.Sc.',
                'user_id' => $user->id,
                'status' => 'published',
                'tags' => 'Just Transition, Critical Minerals, Land Rights, Water Security',
                'published_at' => '2024-09-19 12:20:00',
                'is_pinned' => false,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create($articleData);
        }

        // 4. Projects (Programs, Fellowships, Labs, Fieldwork)
        Project::truncate();
        ProjectImage::truncate();

        $projects = [
            [
                'title' => 'Applied Gender Research Fellowship (AGRF) 2025/2026',
                'description' => "A 12-month intensive residency program pairing 14 emerging scholars with senior legal advocates to investigate emergent gender justice frontiers across Southeast Asia. Fellows receive comprehensive fieldwork grants, monthly stipends, and direct mentorship from leading scholars.\n\nKey Focus Tracks:\n1. Comparative Constitutional Gender Jurisprudence\n2. Just Transition & Political Ecology\n3. Algorithmic Bias and Digital Harassment\n4. Macroeconomic Care Work Accounting",
                'category' => 'Flagship Fellowship',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop',
                'author' => 'Keris Fellowship Directorate',
                'user_id' => $user->id,
                'date' => '2025/2026',
                'published_at' => '2025-01-01',
                'is_pinned' => true,
                'gallery' => [
                    'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop',
                ],
            ],
            [
                'title' => 'Intersectional Gender Policy Lab',
                'description' => "Translating academic rigor into actionable governance toolkits. We prototype and stress-test gender budgeting pathways with regional civil servants, judicial chambers, and community auditors.\n\nOver 120 subnational audits and participatory workshops conducted in partnership with regional development planning agencies (Bappeda).",
                'category' => 'Policy Lab',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=1200&auto=format&fit=crop',
                'author' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'date' => '2024 - 2026 Cycle',
                'published_at' => '2024-06-01',
                'is_pinned' => true,
                'gallery' => [
                    'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=800&auto=format&fit=crop',
                ],
            ],
            [
                'title' => 'Legal Clinic & Public Policy Action',
                'description' => "Pro bono litigation research, amicus curiae briefs preparation, and strategic support for grassroots legal aid bureaus handling structural gender discrimination cases.\n\nKey achievements include 42 partner legal clinics established and 16 community policy briefs submitted to parliamentary committees.",
                'category' => 'Policy Lab',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1200&auto=format&fit=crop',
                'author' => 'Dr. Hendra Wibowo, S.H., LL.M.',
                'user_id' => $user->id,
                'date' => '2023 - Present',
                'published_at' => '2023-09-15',
                'is_pinned' => false,
                'gallery' => [],
            ],
            [
                'title' => 'Grassroots Feminist Leadership Academy',
                'description' => "Intensive residential capacity-building academies for local women village leaders, indigenous representatives, and labor organizers across 12 provinces.\n\nProvides empirical tools in gender-responsive public budgeting, statutory labor rights negotiation, and participatory community research methodologies.",
                'category' => 'Community Initiative',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=1200&auto=format&fit=crop',
                'author' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'date' => 'Annual Cycle',
                'published_at' => '2024-03-10',
                'is_pinned' => false,
                'gallery' => [],
            ],
            [
                'title' => 'Just Transition & Coastal Climate Initiative',
                'description' => "Longitudinal field monitoring of artisanal coastal fisherwomen livelihoods, saltwater intrusion impacts, and participatory climate adaptation financing in Demak, Pekalongan, and Halmahera.",
                'category' => 'Research Initiative',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1200&auto=format&fit=crop',
                'author' => 'Dr. Kartika Rahayu, M.Sc.',
                'user_id' => $user->id,
                'date' => '2024 - 2026',
                'published_at' => '2024-05-20',
                'is_pinned' => false,
                'gallery' => [],
            ],
            // In Situ Fieldwork items
            [
                'title' => 'Participatory Ethnography in Slum Wards',
                'description' => 'Direct immersion with informal settlement women along tidal canals to map informal sanitation networks and collective childcare collectives.',
                'category' => 'In Situ Fieldwork',
                'status' => 'Selesai',
                'image' => 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=800&auto=format&fit=crop',
                'author' => 'Farhan Maulana, S.Sos.',
                'user_id' => $user->id,
                'date' => 'Field Record: JKT-04',
                'published_at' => '2024-10-01',
                'is_pinned' => false,
                'gallery' => [],
            ],
            [
                'title' => 'Community Validation of Gender Budget',
                'description' => 'Co-designing subnational budget audits with market stall vendor associations and female artisanal fishers in Demak and Pekalongan.',
                'category' => 'In Situ Fieldwork',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=800&auto=format&fit=crop',
                'author' => 'Dian Pratiwi, M.A.',
                'user_id' => $user->id,
                'date' => 'Field Record: PKL-12',
                'published_at' => '2024-11-15',
                'is_pinned' => false,
                'gallery' => [],
            ],
            [
                'title' => 'Critical Deconstruction Academic Study',
                'description' => 'Cross-regional scholar symposium dissecting structural patriarchal jurisprudence across Southeast Asian legal systems.',
                'category' => 'In Situ Fieldwork',
                'status' => 'Aktif',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop',
                'author' => 'Prof. Dr. Amanda Dewi, Ph.D.',
                'user_id' => $user->id,
                'date' => 'Symposium 2025',
                'published_at' => '2025-01-20',
                'is_pinned' => false,
                'gallery' => [],
            ],
        ];

        foreach ($projects as $proj) {
            $gallery = $proj['gallery'] ?? [];
            unset($proj['gallery']);

            $createdProject = Project::create($proj);

            foreach ($gallery as $order => $imgUrl) {
                ProjectImage::create([
                    'project_id' => $createdProject->id,
                    'image' => $imgUrl,
                    'order' => $order + 1,
                ]);
            }
        }

        // 5. Partners
        Partner::truncate();

        $partners = [
            ['name' => 'BRIN (Badan Riset & Inovasi Nasional)', 'logo' => 'BRIN'],
            ['name' => 'Komnas Perempuan', 'logo' => 'KOMNAS PEREMPUAN'],
            ['name' => 'Universitas Gadjah Mada', 'logo' => 'UGM'],
            ['name' => 'Ford Foundation', 'logo' => 'FORD FOUNDATION'],
            ['name' => 'UN Women Global', 'logo' => 'UN WOMEN'],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }

        // 6. Hero Photos
        HeroPhoto::truncate();

        HeroPhoto::create([
            'image' => 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=1600&auto=format&fit=crop',
            'caption' => 'Women Fishers Resistance in Wawonii: Mining & Ecosystem Destruction',
            'order' => 1,
            'is_active' => true,
        ]);
        HeroPhoto::create([
            'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1600&auto=format&fit=crop',
            'caption' => 'Agrarian Living Commons & Peasant Assembly in Central Java',
            'order' => 2,
            'is_active' => true,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
