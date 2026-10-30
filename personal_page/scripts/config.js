// Configuration for Glen David Hadiono's Personal Portfolio
window.siteConfig = {
  profile: {
    name: "Glen David",
    fullName: "Glen David Hadiono",
    title: "my little corner of the internet",
    sentence: "Welcome to my little corner of the internet.",
    motto: "Analytical Thinker. Builder. Doer.",
    location: "Bandung, West Java, Indonesia",
    email: "glendavid344@gmail.com",
    phone: "+62 851 - 5835 - 2544",
    university: "Telkom University, Makassar",
    major: "S1 Informatics (IPK 3.85)",
    cvUrl: "/cv.pdf",
    portrait: "/images/portrait/glen-full.webp",
    socials: {
      github: "https://github.com/gln15",
      githubUser: "gln15",
      linkedin: "https://linkedin.com/in/glendavid",
      instagram: "https://instagram.com/glendavidd_"
    }
  },

  rooms: {
    developer: {
      label: "Engineer",
      href: "/engineer",
      tagline: "Back-end architecture, Go labs, C++ data structures, and QA testing."
    },
    me: {
      label: "Hire me",
      href: "/hire",
      tagline: "Informatics undergraduate (GPA 3.85), teaching assistant, academic tutor, analytical thinker."
    },
    creative: {
      label: "Creative",
      href: "/creative",
      tagline: "Coming soon."
    }
  },

  hero: {
    src: "/images/portrait/glen-cutout.webp",
    cutout: true,
    focus: { x: 0.50, y: 0.47 },
    backdrop: {
      full: "/images/portrait/glen-full.webp",
      ext: "/images/portrait/glen-ext.webp",
      crop: {
        x: 0,
        y: 0,
        w: 682,
        h: 1024,
        W: 682,
        H: 1024
      }
    },
    brandWords: [
      "Glen", "David", "Hadiono", "Bandung", "Code", "Build", "Ship",
      "Go", "TypeScript", "Node", "C++", "Python", "PHP", "Laravel",
      "PostgreSQL", "MySQL", "Next.js", "QA", "Test", "Analyze",
      "Tutor", "Mentor", "Lead", "Think"
    ]
  },

  marqueeGroups: [
    {
      key: "builder",
      label: "builder",
      words: [
        { w: "Software engineer", q: "code" },
        { w: "Back-end engineer", q: "code" },
        { w: "Quality assurance tester", q: "qa" },
        { w: "TypeScript developer", q: "code" },
        { w: "Go developer", q: "code" },
        { w: "C++ developer", q: "code" },
        { w: "Node.js developer", q: "code" },
        { w: "Next.js developer", q: "code" },
        { w: "Web application developer", q: "code" },
        { w: "Database architect", q: "database" }
      ]
    },
    {
      key: "maker",
      label: "maker",
      words: [
        { w: "QA test designer", q: "qa" },
        { w: "Database migrator", q: "database" },
        { w: "Full-stack developer", q: "code" },
        { w: "Laravel & Vite builder", q: "code" },
        { w: "UI/UX collaborator", q: "figma" },
        { w: "Algorithmic challenge builder", q: "algorithms" }
      ]
    },
    {
      key: "thinker",
      label: "thinker",
      words: [
        { w: "Analytical thinker", q: "analytical" },
        { w: "Critical thinker", q: "critical" },
        { w: "Problem solver", q: "problem-solving" },
        { w: "Academic tutor", q: "education" },
        { w: "Data structures analyst", q: "algorithms" },
        { w: "Complexity analyzer", q: "algorithms" }
      ]
    },
    {
      key: "leader",
      label: "leader",
      words: [
        { w: "Programming teaching assistant", q: "assistant" },
        { w: "Data structure TA", q: "assistant" },
        { w: "KONTENT academic tutor", q: "education" },
        { w: "helPhin mentor", q: "mentorship" },
        { w: "Corporate IT intern", q: "intern" },
        { w: "Collaborative team player", q: "teamwork" }
      ]
    },
    {
      key: "human",
      label: "human",
      words: [
        { w: "Telkom University student", q: "telkom" },
        { w: "S1 Informatics (GPA 3.85)" },
        { w: "Bandung resident" },
        { w: "Makassar native" },
        { w: "SMA Negeri 2 Makassar alumnus" },
        { w: "Lifelong learner" }
      ]
    }
  ],

  currently: {
    updated: "2026-10-30",
    items: [
      {
        label: "Assisting",
        value: "Go & C++ Labs (30+ Students, 2 Semesters) at Telkom University",
        href: "/engineer/"
      },
      {
        label: "Tutoring",
        value: "KONTENT HIMA IF & helPhin Academic Mentorship",
        href: "/hire/"
      },
      {
        label: "Building",
        value: "ReuseID & Web Applications",
        href: "/work/"
      }
    ]
  },

  monthlyUpdate: {
    monthYear: "October 2026",
    title: "Teaching Algorithms & Architecting Type-Safe Back-Ends",
    href: "/hire/",
    image: "/images/opt/projects/gooutside-home.webp",
    summary: "Mentoring 30+ students in Go and C++ Data Structures, tutoring core informatics subjects at KONTENT HIMA IF, and building type-safe back-ends with TypeScript and PostgreSQL."
  },

  doors: [
    {
      key: "engineer",
      prompt: "Engineer",
      blurb: "Me behind the laptop: Back-end systems, Go coding labs, C++ data structures, and web applications.",
      href: "/engineer",
      cta: "See what I've built",
      img: "/images/opt/me-working-me-working6-large.webp",
      pos: "50% 40%",
      glow: "rgba(34, 197, 94, .5)"
    },
    {
      key: "hire",
      prompt: "Hire me",
      blurb: "Teaching experience, corporate IT internship, academic tutoring, GPA 3.85, and master CV.",
      href: "/hire",
      cta: "Let's work together",
      img: "/images/opt/me-working-me-working2.webp",
      pos: "70% 50%",
      glow: "rgba(250, 204, 21, .5)"
    },
    {
      key: "creative",
      prompt: "Creative",
      blurb: "Creative projects & showcase — Coming Soon.",
      href: "/creative",
      cta: "Coming Soon",
      img: "/images/opt/me-working-me-working4-large.webp",
      pos: "50% 45%",
      glow: "rgba(47, 111, 237, .55)"
    }
  ],

  musicTracks: [
    {
      title: "Essence",
      artist: "Wizkid feat. Tems",
      preview: "https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview211/v4/b3/dc/ba/b3dcba73-7f33-9abe-089c-73557a6dcb54/mzaf_16412591162283722395.plus.aac.p.m4a"
    },
    {
      title: "Get Lucky",
      artist: "Daft Punk",
      preview: "https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview211/v4/57/a5/85/57a585aa-f1bc-7619-881b-f8a04a5541d5/mzaf_6906185026678279401.plus.aac.p.m4a"
    }
  ],

  catalogWorks: [
    {
      id: "reuseid",
      title: "ReuseID",
      role: "Back-End Engineer & QA",
      year: "2026",
      summary: "Secondhand donation platform with type-safe Node.js/TypeScript architecture, PostgreSQL database migration, automated Vercel deployment, and rigorous QA test suite.",
      tags: ["code", "typescript", "backend", "qa", "postgresql"]
    },
    {
      id: "lunch-attendance",
      title: "Internal Lunch Attendance & Billing System",
      role: "Web Application Developer",
      year: "2026",
      summary: "Internal employee lunch attendance tracking web app integrated with QR code ID cards, role-based access control, admin analytics dashboard, and automated vendor billing reports built with PHP, Laravel Blade, Tailwind CSS, and Vite.",
      tags: ["code", "php", "laravel", "tailwind", "vite"]
    },
    {
      id: "valas-cms",
      title: "Valas Company Profile CMS",
      role: "Full-Stack Developer",
      year: "2026",
      summary: "Prototype corporate website and Content Management System built with Next.js and TypeScript, featuring JWT authentication, bcrypt password hashing, and centralized dynamic content management.",
      tags: ["code", "nextjs", "typescript", "fullstack", "cms"]
    },
    {
      id: "kkn116-tamangapa",
      title: "KKN 116 Tamangapa Platform",
      role: "Web Developer",
      year: "2026",
      summary: "Digital community service platform for Universitas Hasanuddin (KKN 116) documenting environmental initiatives including Eco-enzyme, Ecobrick, and BSF maggot cultivation.",
      tags: ["code", "web", "community"]
    }
  ]
};
