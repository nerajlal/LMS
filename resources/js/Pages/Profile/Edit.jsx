import LmsLayout from '@/Layouts/LmsLayout';
import { Head, usePage } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';

export default function Edit({ mustVerifyEmail, status }) {
    const { auth } = usePage().props;
    const user = auth.user;

    return (
        <LmsLayout title="Profile">
            <Head title="My Profile" />

            <div className="row g-4">
                {/* Left Column: Profile Card */}
                <div className="col-12 col-lg-4">
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '32px', textAlign: 'center' }}>
                        <div style={{ position: 'relative', display: 'inline-block', marginBottom: '20px' }}>
                            <div style={{ width: '120px', height: '120px', borderRadius: '50%', background: '#f1f5f9', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden', margin: '0 auto' }}>
                                <img src={`https://ui-avatars.com/api/?name=${user.name}&size=120&background=random`} alt={user.name} />
                            </div>
                            <button style={{ position: 'absolute', bottom: '0', right: '0', background: '#e3000f', color: '#fff', border: 'none', width: '32px', height: '32px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', cursor: 'pointer' }}>
                                <i className="bi bi-camera"></i>
                            </button>
                        </div>
                        <h2 style={{ fontSize: '20px', fontWeight: 800, color: '#1e293b', marginBottom: '4px' }}>{user.name}</h2>
                        <div style={{ fontSize: '14px', color: '#64748b', marginBottom: '16px' }}>Student</div>
                        
                        <div style={{ display: 'flex', justifyContent: 'center', gap: '20px', borderTop: '1px solid #f1f5f9', paddingTop: '20px', marginTop: '20px' }}>
                            <div>
                                <div style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b' }}>12</div>
                                <div style={{ fontSize: '12px', color: '#64748b' }}>Courses</div>
                            </div>
                            <div>
                                <div style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b' }}>8</div>
                                <div style={{ fontSize: '12px', color: '#64748b' }}>Certificates</div>
                            </div>
                        </div>
                    </div>

                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '24px', marginTop: '24px' }}>
                        <h3 style={{ fontSize: '16px', fontWeight: 800, color: '#1e293b', marginBottom: '16px' }}>Bio</h3>
                        <p style={{ fontSize: '14px', color: '#64748b', margin: 0, lineHeight: 1.6 }}>
                            I am a passionate learner exploring new technologies and building amazing things.
                        </p>
                    </div>
                </div>

                {/* Right Column: Settings Forms */}
                <div className="col-12 col-lg-8">
                    <div className="space-y-6">
                        <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '32px' }}>
                            <UpdateProfileInformationForm
                                mustVerifyEmail={mustVerifyEmail}
                                status={status}
                            />
                        </div>

                        <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '32px' }}>
                            <UpdatePasswordForm />
                        </div>

                        <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '32px', opacity: 0.8 }}>
                            <DeleteUserForm />
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
