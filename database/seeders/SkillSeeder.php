<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Programming Languages
            ['name' => 'JavaScript', 'category' => 'Programming Language'],
            ['name' => 'TypeScript', 'category' => 'Programming Language'],
            ['name' => 'Python', 'category' => 'Programming Language'],
            ['name' => 'Java', 'category' => 'Programming Language'],
            ['name' => 'C#', 'category' => 'Programming Language'],
            ['name' => 'C++', 'category' => 'Programming Language'],
            ['name' => 'C', 'category' => 'Programming Language'],
            ['name' => 'Go', 'category' => 'Programming Language'],
            ['name' => 'Rust', 'category' => 'Programming Language'],
            ['name' => 'PHP', 'category' => 'Programming Language'],
            ['name' => 'Ruby', 'category' => 'Programming Language'],
            ['name' => 'Swift', 'category' => 'Programming Language'],
            ['name' => 'Kotlin', 'category' => 'Programming Language'],
            ['name' => 'Dart', 'category' => 'Programming Language'],
            ['name' => 'Scala', 'category' => 'Programming Language'],
            ['name' => 'R', 'category' => 'Programming Language'],
            ['name' => 'MATLAB', 'category' => 'Programming Language'],
            ['name' => 'Elixir', 'category' => 'Programming Language'],
            ['name' => 'Haskell', 'category' => 'Programming Language'],
            ['name' => 'Perl', 'category' => 'Programming Language'],
            ['name' => 'Lua', 'category' => 'Programming Language'],
            ['name' => 'Shell/Bash', 'category' => 'Programming Language'],
            ['name' => 'PowerShell', 'category' => 'Programming Language'],
            ['name' => 'Objective-C', 'category' => 'Programming Language'],
            ['name' => 'Clojure', 'category' => 'Programming Language'],

            // Frontend Frameworks & Libraries
            ['name' => 'React', 'category' => 'Frontend Framework'],
            ['name' => 'Vue.js', 'category' => 'Frontend Framework'],
            ['name' => 'Angular', 'category' => 'Frontend Framework'],
            ['name' => 'Svelte', 'category' => 'Frontend Framework'],
            ['name' => 'Next.js', 'category' => 'Frontend Framework'],
            ['name' => 'Nuxt.js', 'category' => 'Frontend Framework'],
            ['name' => 'Remix', 'category' => 'Frontend Framework'],
            ['name' => 'Solid.js', 'category' => 'Frontend Framework'],
            ['name' => 'Astro', 'category' => 'Frontend Framework'],
            ['name' => 'jQuery', 'category' => 'Frontend Framework'],
            ['name' => 'Alpine.js', 'category' => 'Frontend Framework'],
            ['name' => 'Ember.js', 'category' => 'Frontend Framework'],
            ['name' => 'Backbone.js', 'category' => 'Frontend Framework'],
            ['name' => 'Preact', 'category' => 'Frontend Framework'],
            ['name' => 'Lit', 'category' => 'Frontend Framework'],

            // Backend Frameworks
            ['name' => 'Laravel', 'category' => 'Backend Framework'],
            ['name' => 'Django', 'category' => 'Backend Framework'],
            ['name' => 'Flask', 'category' => 'Backend Framework'],
            ['name' => 'FastAPI', 'category' => 'Backend Framework'],
            ['name' => 'Express.js', 'category' => 'Backend Framework'],
            ['name' => 'Nest.js', 'category' => 'Backend Framework'],
            ['name' => 'Spring Boot', 'category' => 'Backend Framework'],
            ['name' => 'ASP.NET Core', 'category' => 'Backend Framework'],
            ['name' => 'Ruby on Rails', 'category' => 'Backend Framework'],
            ['name' => 'Symfony', 'category' => 'Backend Framework'],
            ['name' => 'CodeIgniter', 'category' => 'Backend Framework'],
            ['name' => 'Gin', 'category' => 'Backend Framework'],
            ['name' => 'Fiber', 'category' => 'Backend Framework'],
            ['name' => 'Phoenix', 'category' => 'Backend Framework'],
            ['name' => 'Actix', 'category' => 'Backend Framework'],
            ['name' => 'Rocket', 'category' => 'Backend Framework'],
            ['name' => 'Sinatra', 'category' => 'Backend Framework'],
            ['name' => 'Koa', 'category' => 'Backend Framework'],
            ['name' => 'Hapi', 'category' => 'Backend Framework'],

            // Mobile Development
            ['name' => 'React Native', 'category' => 'Mobile Development'],
            ['name' => 'Flutter', 'category' => 'Mobile Development'],
            ['name' => 'SwiftUI', 'category' => 'Mobile Development'],
            ['name' => 'Jetpack Compose', 'category' => 'Mobile Development'],
            ['name' => 'Ionic', 'category' => 'Mobile Development'],
            ['name' => 'Xamarin', 'category' => 'Mobile Development'],
            ['name' => 'Cordova', 'category' => 'Mobile Development'],
            ['name' => 'NativeScript', 'category' => 'Mobile Development'],
            ['name' => 'Expo', 'category' => 'Mobile Development'],

            // Databases
            ['name' => 'MySQL', 'category' => 'Database'],
            ['name' => 'PostgreSQL', 'category' => 'Database'],
            ['name' => 'MongoDB', 'category' => 'Database'],
            ['name' => 'Redis', 'category' => 'Database'],
            ['name' => 'SQLite', 'category' => 'Database'],
            ['name' => 'MariaDB', 'category' => 'Database'],
            ['name' => 'Microsoft SQL Server', 'category' => 'Database'],
            ['name' => 'Oracle Database', 'category' => 'Database'],
            ['name' => 'Cassandra', 'category' => 'Database'],
            ['name' => 'DynamoDB', 'category' => 'Database'],
            ['name' => 'Firebase Firestore', 'category' => 'Database'],
            ['name' => 'Elasticsearch', 'category' => 'Database'],
            ['name' => 'CouchDB', 'category' => 'Database'],
            ['name' => 'Neo4j', 'category' => 'Database'],
            ['name' => 'InfluxDB', 'category' => 'Database'],
            ['name' => 'TimescaleDB', 'category' => 'Database'],
            ['name' => 'Supabase', 'category' => 'Database'],
            ['name' => 'PlanetScale', 'category' => 'Database'],
            ['name' => 'CockroachDB', 'category' => 'Database'],

            // DevOps & Cloud
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'Kubernetes', 'category' => 'DevOps'],
            ['name' => 'AWS', 'category' => 'DevOps'],
            ['name' => 'Google Cloud Platform', 'category' => 'DevOps'],
            ['name' => 'Azure', 'category' => 'DevOps'],
            ['name' => 'Terraform', 'category' => 'DevOps'],
            ['name' => 'Ansible', 'category' => 'DevOps'],
            ['name' => 'Jenkins', 'category' => 'DevOps'],
            ['name' => 'GitHub Actions', 'category' => 'DevOps'],
            ['name' => 'GitLab CI/CD', 'category' => 'DevOps'],
            ['name' => 'CircleCI', 'category' => 'DevOps'],
            ['name' => 'Travis CI', 'category' => 'DevOps'],
            ['name' => 'ArgoCD', 'category' => 'DevOps'],
            ['name' => 'Helm', 'category' => 'DevOps'],
            ['name' => 'Prometheus', 'category' => 'DevOps'],
            ['name' => 'Grafana', 'category' => 'DevOps'],
            ['name' => 'ELK Stack', 'category' => 'DevOps'],
            ['name' => 'Datadog', 'category' => 'DevOps'],
            ['name' => 'New Relic', 'category' => 'DevOps'],
            ['name' => 'Nginx', 'category' => 'DevOps'],
            ['name' => 'Apache', 'category' => 'DevOps'],
            ['name' => 'Vagrant', 'category' => 'DevOps'],
            ['name' => 'Chef', 'category' => 'DevOps'],
            ['name' => 'Puppet', 'category' => 'DevOps'],
            ['name' => 'Consul', 'category' => 'DevOps'],
            ['name' => 'Vault', 'category' => 'DevOps'],

            // CSS & Styling
            ['name' => 'CSS', 'category' => 'CSS & Styling'],
            ['name' => 'Sass/SCSS', 'category' => 'CSS & Styling'],
            ['name' => 'Less', 'category' => 'CSS & Styling'],
            ['name' => 'Tailwind CSS', 'category' => 'CSS & Styling'],
            ['name' => 'Bootstrap', 'category' => 'CSS & Styling'],
            ['name' => 'Material-UI', 'category' => 'CSS & Styling'],
            ['name' => 'Chakra UI', 'category' => 'CSS & Styling'],
            ['name' => 'Ant Design', 'category' => 'CSS & Styling'],
            ['name' => 'Styled Components', 'category' => 'CSS & Styling'],
            ['name' => 'Emotion', 'category' => 'CSS & Styling'],
            ['name' => 'PostCSS', 'category' => 'CSS & Styling'],
            ['name' => 'CSS Modules', 'category' => 'CSS & Styling'],
            ['name' => 'shadcn/ui', 'category' => 'CSS & Styling'],
            ['name' => 'DaisyUI', 'category' => 'CSS & Styling'],

            // Testing
            ['name' => 'Jest', 'category' => 'Testing'],
            ['name' => 'Pytest', 'category' => 'Testing'],
            ['name' => 'PHPUnit', 'category' => 'Testing'],
            ['name' => 'JUnit', 'category' => 'Testing'],
            ['name' => 'Mocha', 'category' => 'Testing'],
            ['name' => 'Chai', 'category' => 'Testing'],
            ['name' => 'Cypress', 'category' => 'Testing'],
            ['name' => 'Playwright', 'category' => 'Testing'],
            ['name' => 'Selenium', 'category' => 'Testing'],
            ['name' => 'TestCafe', 'category' => 'Testing'],
            ['name' => 'Vitest', 'category' => 'Testing'],
            ['name' => 'React Testing Library', 'category' => 'Testing'],
            ['name' => 'Jasmine', 'category' => 'Testing'],
            ['name' => 'Karma', 'category' => 'Testing'],
            ['name' => 'Postman', 'category' => 'Testing'],
            ['name' => 'Insomnia', 'category' => 'Testing'],
            ['name' => 'K6', 'category' => 'Testing'],
            ['name' => 'JMeter', 'category' => 'Testing'],

            // API & Communication
            ['name' => 'REST API', 'category' => 'API'],
            ['name' => 'GraphQL', 'category' => 'API'],
            ['name' => 'gRPC', 'category' => 'API'],
            ['name' => 'WebSocket', 'category' => 'API'],
            ['name' => 'tRPC', 'category' => 'API'],
            ['name' => 'Apollo GraphQL', 'category' => 'API'],
            ['name' => 'Prisma', 'category' => 'API'],
            ['name' => 'Hasura', 'category' => 'API'],
            ['name' => 'Swagger/OpenAPI', 'category' => 'API'],

            // AI/ML & Data Science
            ['name' => 'TensorFlow', 'category' => 'AI/ML'],
            ['name' => 'PyTorch', 'category' => 'AI/ML'],
            ['name' => 'scikit-learn', 'category' => 'AI/ML'],
            ['name' => 'Keras', 'category' => 'AI/ML'],
            ['name' => 'Pandas', 'category' => 'AI/ML'],
            ['name' => 'NumPy', 'category' => 'AI/ML'],
            ['name' => 'Matplotlib', 'category' => 'AI/ML'],
            ['name' => 'Seaborn', 'category' => 'AI/ML'],
            ['name' => 'Jupyter', 'category' => 'AI/ML'],
            ['name' => 'OpenCV', 'category' => 'AI/ML'],
            ['name' => 'NLTK', 'category' => 'AI/ML'],
            ['name' => 'spaCy', 'category' => 'AI/ML'],
            ['name' => 'Hugging Face', 'category' => 'AI/ML'],
            ['name' => 'LangChain', 'category' => 'AI/ML'],
            ['name' => 'OpenAI API', 'category' => 'AI/ML'],

            // Game Development
            ['name' => 'Unity', 'category' => 'Game Development'],
            ['name' => 'Unreal Engine', 'category' => 'Game Development'],
            ['name' => 'Godot', 'category' => 'Game Development'],
            ['name' => 'Three.js', 'category' => 'Game Development'],
            ['name' => 'Babylon.js', 'category' => 'Game Development'],
            ['name' => 'Phaser', 'category' => 'Game Development'],
            ['name' => 'Pygame', 'category' => 'Game Development'],

        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}