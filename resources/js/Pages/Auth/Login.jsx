import { Head, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), { onFinish: () => reset('password') });
    };

    return (
        <>
            <Head title="Login - EduLMS" />
            <div style={{
                minHeight: '100vh',
                background: 'linear-gradient(135deg, #0f1117 0%, #1a1d2e 100%)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '20px',
                fontFamily: "'Inter', sans-serif",
            }}>
                {/* Background decorations */}
                <div style={{ position: 'fixed', top: 0, left: 0, right: 0, bottom: 0, overflow: 'hidden', pointerEvents: 'none' }}>
                    <div style={{ position: 'absolute', top: '-10%', right: '-5%', width: '500px', height: '500px', background: 'radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%)', borderRadius: '50%' }}></div>
                    <div style={{ position: 'absolute', bottom: '-10%', left: '-5%', width: '400px', height: '400px', background: 'radial-gradient(circle, rgba(79,70,229,0.12) 0%, transparent 70%)', borderRadius: '50%' }}></div>
                </div>

                <div style={{ width: '100%', maxWidth: '420px', position: 'relative', zIndex: 10 }}>
                    {/* Logo */}
                    <div style={{ textAlign: 'center', marginBottom: '32px' }}>
                        <div style={{
                            width: '60px', height: '60px', borderRadius: '16px',
                            background: 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                            display: 'flex', alignItems: 'center', justifyContent: 'center',
                            margin: '0 auto 14px',
                            boxShadow: '0 12px 40px rgba(124,58,237,0.4)',
                        }}>
                            <i className="bi bi-mortarboard-fill" style={{ color: '#fff', fontSize: '28px' }}></i>
                        </div>
                        <h1 style={{ color: '#fff', fontSize: '26px', fontWeight: 800, margin: '0 0 4px 0', letterSpacing: '-0.5px' }}>EduLMS</h1>
                        <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: 0 }}>Sign in to your account</p>
                    </div>

                    {/* Card */}
                    <div style={{
                        background: 'rgba(255,255,255,0.05)',
                        border: '1px solid rgba(255,255,255,0.1)',
                        borderRadius: '20px',
                        padding: '32px',
                        backdropFilter: 'blur(12px)',
                        boxShadow: '0 24px 60px rgba(0,0,0,0.4)',
                    }}>
                        {status && (
                            <div style={{ background: '#10b98122', border: '1px solid #10b98144', borderRadius: '8px', padding: '10px 14px', color: '#10b981', fontSize: '13px', marginBottom: '20px' }}>
                                {status}
                            </div>
                        )}

                        <form onSubmit={submit}>
                            <div style={{ marginBottom: '18px' }}>
                                <label style={{ color: 'rgba(255,255,255,0.7)', fontSize: '13px', fontWeight: 500, display: 'block', marginBottom: '8px' }}>
                                    Email Address
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={e => setData('email', e.target.value)}
                                    autoComplete="username"
                                    autoFocus
                                    required
                                    placeholder="you@email.com"
                                    style={{
                                        width: '100%', background: 'rgba(255,255,255,0.08)', border: `1px solid ${errors.email ? '#ef4444' : 'rgba(255,255,255,0.12)'}`,
                                        borderRadius: '10px', color: '#fff', padding: '12px 14px', fontSize: '14px', outline: 'none', boxSizing: 'border-box',
                                    }}
                                />
                                {errors.email && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.email}</div>}
                            </div>

                            <div style={{ marginBottom: '24px' }}>
                                <div className="d-flex justify-content-between align-items-center" style={{ marginBottom: '8px' }}>
                                    <label style={{ color: 'rgba(255,255,255,0.7)', fontSize: '13px', fontWeight: 500 }}>Password</label>
                                    {canResetPassword && (
                                        <a href={route('password.request')} style={{ color: '#7c3aed', fontSize: '12px', textDecoration: 'none' }}>Forgot password?</a>
                                    )}
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    value={data.password}
                                    onChange={e => setData('password', e.target.value)}
                                    autoComplete="current-password"
                                    required
                                    placeholder="••••••••"
                                    style={{
                                        width: '100%', background: 'rgba(255,255,255,0.08)', border: `1px solid ${errors.password ? '#ef4444' : 'rgba(255,255,255,0.12)'}`,
                                        borderRadius: '10px', color: '#fff', padding: '12px 14px', fontSize: '14px', outline: 'none', boxSizing: 'border-box',
                                    }}
                                />
                                {errors.password && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.password}</div>}
                            </div>

                            <button
                                type="submit"
                                disabled={processing}
                                style={{
                                    width: '100%', padding: '13px', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                                    color: '#fff', border: 'none', borderRadius: '12px', fontSize: '15px', fontWeight: 700,
                                    cursor: processing ? 'not-allowed' : 'pointer', opacity: processing ? 0.7 : 1,
                                    boxShadow: '0 8px 24px rgba(124,58,237,0.35)',
                                    transition: 'all 0.2s',
                                }}
                            >
                                {processing ? 'Signing in...' : 'Sign In'}
                            </button>
                        </form>
                    </div>

                    <p style={{ textAlign: 'center', color: 'rgba(255,255,255,0.4)', fontSize: '13px', marginTop: '20px' }}>
                        Don't have an account?{' '}
                        <a href={route('register')} style={{ color: '#7c3aed', textDecoration: 'none', fontWeight: 600 }}>Apply for Admission</a>
                    </p>
                </div>
            </div>
        </>
    );
}
