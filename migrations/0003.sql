INSERT INTO job_category(name) VALUES
	/* 1 */ ('AI Engineer'),
	/* 2 */ ('Cyber Security'),
	/* 3 */ ('Infrastructure Management'),
	/* 4 */ ('Quality Assurance'),
	/* 5 */ ('Software Development'),
	/* 6 */ ('Tech Support');

INSERT INTO job(
	id, category_id, company, superior,
	name, location,
	salary_min, salary_max, salary_currency, exp_min, exp_max,
	description
) VALUES (
	'LCI52', 1, 'Pacific Ridge Insights', 'Director of Machine Learning',
	'Senior Machine-Learning Engineer', 'San Francisco, United States',
	150000, 195000, 'USD', 5, 8,
	'Design, train, and deploy production-scale ML models for recommendation and personalization systems. Collaborate with product and engineering to integrate models into user-facing services and monitor performance in production.'
), (
	'HAO39', 1, 'Aurora Dataworks', 'Head of AI Engineering',
	'Computer Vision Specialist', 'Toronto, Canada',
	110000, 140000, 'CAD', 4, 6,
	'Develop and deploy computer vision models for image and video analysis pipelines, including data augmentation, annotation tooling, and inference at scale'
), (
	'MDS91', 1, 'North Harbor Analytics', 'Head of Data Engineering',
	'Machine-Learning Platform Engineer', 'London, United Kingdom',
	95000, 125000, 'GBP', 4, 7,
	'Build and maintain machine-learning infrastructures: model training pipelines, feature stores, experiment tracking, and deployment tooling to enable rapid iteration for machine-learning teams.'
), (
	'ZBA91', 1, 'Meridian Retail Labs', 'Lead ML Engineer',
	'Junior AI/Machine-Learning Engineer', 'Berlin, Germany',
	45000, 65000, 'EUR', 0, 2,
	'Support model development and evaluation, prepare datasets, run experiments, and help deploy models under guidance from senior engineers.'
), (
	'VEE49', 1, 'Clearview Financial Systems', 'Director of Research',
	'Natural-Language-Processor Specialist', 'Sydney, Australia',
	140000, 180000, 'AUD', 4, 7,
	'Develop state-of-the-art NLP models for financial document understanding, information extraction, and question-answering systems. Work closely with research scientists and product teams to deploy models that meet regulatory and accuracy requirements.'
), (
	'AIU64', 5, 'Meridian Pixelworks', 'Senior Engineering Lead',
	'Full-Stack Software Engineer', 'Dublin, Ireland',
	70000, 95000, 'EUR', 3, 5,
	'Build end-to-end features across frontend and backend, collaborate with product/design to deliver user-facing web applications, and maintain CI/CD pipelines.'
	), (
	'COR46', 5, 'Blue Mesa Systems', 'Engineering Manager',
	'Senior Backend Developer', 'Austin, United States',
	140000, 180000, 'USD', 5, 8,
	'Design and implement scalable backend services and APIs, own core system components, and drive architectural improvements for high-throughput applications.'
), (
	'IUC60', 5, 'Harborlight Mobile', 'Mobile Engineering Manager',
	'Mobile Application Engineer (iOS / Android)', 'Vancouver, Canada',
	100000, 125000, 'CAD', 3, 6,
	'Develop and maintain native and cross-platform mobile applications, deliver performant UX, and integrate apps with backend services and push-notification systems.'
), (
	'ZHA71', 3, 'Red Lantern Infrastructure', 'Head of IT Department',
	'Senior Systems Administrator', 'Shenzhen, China',
	220000, 320000, 'CNY', 4, 7,
	'Maintain and operate the company''s mixed cloud and on-prem infrastructure, ensure system availability and security, manage backups and disaster recovery, and support platform automation and monitoring.'
), (
	'JNW01', 2, 'KumoShield Security Corp.', 'Head of Infrastructure',
	'Threat Intelligence Analyst', 'Tokyo, Japan',
	8500000, 11500000, 'JPY', 4, 7,
	'Operate and secure hybrid infrastructure, manage identity and access, ensure system availability, and support incident response and forensics for security-focused services.'
), (
	'VKE99', 2, 'LotusGuard CyberTech', 'Infrastructure & Security Manager',
	'Senior Cryptography Engineer', 'Ho Chi Minh City, Vietnam',
	420000000, 650000000, 'VND', 6, 8,
	'Manage and secure on-prem and cloud systems, implement monitoring and backup strategies, and collaborate with SOC teams to respond to security incidents and maintain compliance.'
);


INSERT INTO job_requirement(id, name, value) VALUES
	('LCI52', 'langs', 'Python, SQL'),
	('LCI52', 'tools', 'TensorFlow or PyTorch, scikit-learn, and Docker'),
	('LCI52', 'opt-1', 'Lead model architecture reviews and mentorship for junior engineers'),
	('LCI52', 'opt-2', 'Implement model monitoring, drift detection, and A/B testing'),
	('LCI52', 'opt-3', 'Optimize model serving latency and cost on cloud platforms (AWS/GCP)'),
	('LCI52', 'opt-4', 'Collaborate on data labeling strategies and feature stores'),

	('HAO39', 'langs', 'Python, C++ (optional), SQL'),
	('HAO39', 'tools', 'PyTorch, OpenCV, TensorRT, Kubernetes'),
	('HAO39', 'opt-1', 'Build labeling and augmentation pipelines; improve annotation workflows'),
	('HAO39', 'opt-2', 'Optimize inference for edge devices and GPU clusters'),
	('HAO39', 'opt-3', 'Integrate vision models into CI/CD and monitoring systems.'),
	('HAO39', 'opt-4', 'Research and prototype novel architectures for detection/segmentation'),

	('MDS91', 'langs', 'Python, Bash, SQL'),
	('MDS91', 'tools', 'Kubeflow or MLflow, Airflow, Terraform, AWS/GCP'),
	('MDS91', 'opt-1', 'Implement reproducible training pipelines and experiment tracking'),
	('MDS91', 'opt-2', 'Manage model registry and governance workflows'),
	('MDS91', 'opt-3', 'Automate resource provisioning and cost controls for training jobs'),
	('MDS91', 'opt-4', 'Provide internal tools and training to improve ML team productivity'),

	('ZBA91', 'langs', 'Python, SQL'),
	('ZBA91', 'tools', 'PyTorch or TensorFlow, Jupyter, Docker'),
	('ZBA91', 'opt-1', 'Assist with data preprocessing, feature engineering, and labeling'),
	('ZBA91', 'opt-2', 'Write unit tests and CI for model code; maintain experiment logs'),
	('ZBA91', 'opt-3', 'Monitor model performance and produce reproducible training runs'),
	('ZBA91', 'opt-4', 'Participate in code reviews and documentation'),

	('VEE49', 'langs', 'Python, SQL'),
	('VEE49', 'tools', 'Transformers (Hugging Face), PyTorch/TensorFlow, spaCy'),
	('VEE49', 'opt-1', 'Research and implement fine-tuning strategies for domain adaptation'),
	('VEE49', 'opt-2', 'Build end-to-end pipelines for annotation, training, and deployment'),
	('VEE49', 'opt-3', 'Ensure model explainability and compliance with audit requirements'),
	('VEE49', 'opt-4', 'Mentor interns and collaborate with cross-functional stakeholders'),

	('AIU64', 'langs', 'JavaScript/TypeScript, SQL'),
	('AIU64', 'tools', 'React, Node.js/Express, Next.js, Docker, AWS or Vercel'),
	('AIU64', 'opt-1', 'Own feature rollout and A/B experiments with product teams'),
	('AIU64', 'opt-2', 'Improve frontend performance and accessibility standards'),
	('AIU64', 'opt-3', 'Develop reusable component libraries and shared services'),
	('AIU64', 'opt-4', 'Write integration tests and maintain deployment automation'),

	('COR46', 'langs', 'Java or Go, SQL'),
	('COR46', 'tools', 'Spring Boot or Go net/http, Docker, Kubernetes, PostgreSQL'),
	('COR46', 'opt-1', 'Lead system design reviews and mentor mid/junior engineers'),
	('COR46', 'opt-2', 'Improve service observability, performance tuning, and capacity planning'),
	('COR46', 'opt-3', 'Drive migration to microservices or service mesh architectures'),
	('COR46', 'opt-4', 'Participate in on-call rotation and incident postmortems'),

	('IUC60', 'langs', 'Swift (iOS) or Kotlin (Android), familiarity with REST/GraphQL'),
	('IUC60', 'tools', 'SwiftUI/UIKit or Jetpack Compose, React Native or Flutter (optional), Firebase, CI tools'),
	('IUC60', 'opt-1', 'Implement analytics, feature flagging, and remote config systems'),
	('IUC60', 'opt-2', 'Optimize app startup time, memory, and battery usage'),
	('IUC60', 'opt-3', 'Lead releases and coordinate with QA for beta testing'),
	('IUC60', 'opt-4', 'Contribute to cross-platform code-sharing strategies'),

	('ZHA71', 'langs', 'Bash, Python, SQL'),
	('ZHA71', 'tools', 'Linux (CentOS/Ubuntu), Windows Server, VMware or Hyper-V, AWS or Azure'),
	('ZHA71', 'opt-1', 'Implement and maintain infrastructure-as-code (Terraform/Ansible) and CI/CD for ops workflows'),
	('ZHA71', 'opt-2', 'Build monitoring, alerting, and incident response playbooks with Prometheus/Grafana or alternative stacks'),
	('ZHA71', 'opt-3', 'Manage backup/DR plans, patching, and capacity planning across data centers'),
	('ZHA71', 'opt-4', 'Harden systems for security compliance and coordinate with security teams for audits'),

	('JNW01', 'langs', 'Bash, Python, PowerShell'),
	('JNW01', 'tools', 'Linux (Ubuntu/CentOS), Windows Server, AWS/GCP, VMware, EDR tooling'),
	('JNW01', 'opt-1', 'Maintain and automate infrastructure-as-code (Terraform/Ansible) for secure deployments'),
	('JNW01', 'opt-2', 'Integrate and tune SIEM/EDR, logging, and alerting for threat detection'),
	('JNW01', 'opt-3', 'Support incident response, forensic data collection, and vulnerability remediation'),
	('JNW01', 'opt-4', 'Participate in security reviews, hardening, and compliance activities'),

	('VKE99', 'langs', 'C, C++, Bash'),
	('VKE99', 'tools', 'Linux (Debian/CentOS), Windows Server, AWS/Azure, Docker, SIEM solutions'),
	('VKE99', 'opt-1', 'Automate deployment, patching, and configuration management with Ansible/Terraform'),
	('VKE99', 'opt-2', 'Operate SIEM and logging pipelines; create detection rules and dashboards'),
	('VKE99', 'opt-3', 'Conduct system hardening, vulnerability scans, and coordinate remediation'),
	('VKE99', 'opt-4', 'Support incident response exercises and maintain runbooks and playbooks');

