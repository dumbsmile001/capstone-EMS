<div class="bg-white rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <div class="relative bg-gradient-to-br from-blue-50 to-yellow-50 shadow-xs rounded-xl border border-blue-100">
            <!-- Search and Filter Controls -->
            <div class="p-5 bg-white/80 backdrop-blur-sm border-b border-blue-100 rounded-t-xl">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-semibold text-blue-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users Management
                    </h3>
                    <button wire:click="openGenerateReportModal"
                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg hover:from-green-500 hover:to-green-600 transition-all duration-200 text-sm font-medium flex items-center gap-2 shadow-md shadow-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Report
                    </button>
                </div>

                <!-- Filter Grid - same as your existing filters -->
                <div class="space-y-4">
                    <!-- First Row: Search and Grade/Year Level -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <!-- Search Box - Expanded -->
                        <div class="md:col-span-2">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-400 group-focus-within:text-yellow-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    class="block w-full pl-10 pr-4 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                    placeholder="Search by name, email, or student ID...">
                            </div>
                        </div>

                        <!-- Grade Level Filter -->
                        <div>
                            <select wire:model.live="filterGradeLevel"
                                class="block w-full px-3 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 appearance-none cursor-pointer">
                                <option value="">📋 All Grade Levels</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>

                        <!-- Year Level Filter -->
                        <div>
                            <select wire:model.live="filterYearLevel"
                                class="block w-full px-3 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="">📚 All Year Levels</option>
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                                <option value="5">Year 5</option>
                            </select>
                        </div>
                    </div>

                    <!-- Second Row: Strand, Program, Role, Per Page -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <!-- SHS Strand Filter -->
                        <div>
                            <select wire:model.live="filterSHSStrand"
                                class="block w-full px-3 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="">🎓 All SHS Strands</option>
                                <option value="ABM">ABM</option>
                                <option value="HUMSS">HUMSS</option>
                                <option value="GAS">GAS</option>
                                <option value="ICT">ICT</option>
                            </select>
                        </div>

                        <!-- College Program Filter -->
                        <div>
                            <select wire:model.live="filterCollegeProgram"
                                class="block w-full px-3 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="">🏫 All College Programs</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BSBA">BSBA</option>
                            </select>
                        </div>

                        <!-- Role Filter -->
                        <div>
                            <select wire:model.live="filterRole"
                                class="block w-full px-3 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="">👥 All Roles</option>
                                @foreach ($availableRoles as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Results Per Page -->
                        <div>
                            <select wire:model.live="perPage"
                                class="block w-full px-3 py-2.5 text-sm border-2 border-blue-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="10">📄 10 per page</option>
                                <option value="25">📄 25 per page</option>
                                <option value="50">📄 50 per page</option>
                                <option value="100">📄 100 per page</option>
                            </select>
                        </div>

                        <!-- Reset Filters Button -->
                        <div>
                            <button wire:click="resetFilters"
                                class="w-full px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 border-2 border-blue-200 rounded-xl hover:bg-yellow-50 hover:border-yellow-400 hover:text-yellow-700 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-100">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Name</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Email</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Grade Level</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Year Level</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">SHS Strand</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">College Program</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Student ID</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Role</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-50">
                        @forelse($users as $index => $user)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white hover:bg-blue-50' : 'bg-blue-50/30 hover:bg-blue-100' }} transition-colors duration-150 group">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($user->grade_level)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-medium">{{ $user->grade_level }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($user->year_level)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-medium">{{ $user->year_level }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($user->shs_strand)
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium">{{ $user->shs_strand }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($user->college_program)
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium">{{ $user->college_program }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($user->student_id)
                                        <span class="font-mono text-xs">{{ $user->student_id }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 py-1 {{ $role->name === 'admin' ? 'bg-purple-100 text-purple-800' : ($role->name === 'organizer' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }} rounded-lg text-xs font-medium capitalize">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <!-- Edit Button -->
                                        <button wire:click="openEditUserModal({{ $user->id }})"
                                            class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-600 hover:text-white transition-all duration-200 group/edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        
                                        <!-- Delete Button -->
                                        <button wire:click="openDeleteUserModal({{ $user->id }})"
                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 group/delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 mb-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-blue-800">No users found</p>
                                        <p class="text-sm text-blue-600 mt-1">
                                            @if ($search || $filterGradeLevel || $filterYearLevel || $filterSHSStrand || $filterCollegeProgram || $filterRole)
                                                Try adjusting your search or filters
                                            @else
                                                No users in the system yet
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modern Pagination -->
            @if ($users && method_exists($users, 'links'))
                <div class="px-4 py-4 bg-white/80 backdrop-blur-sm border-t border-blue-100 rounded-b-xl">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-blue-700">
                            Showing <span class="font-semibold">{{ $users->firstItem() ?? 0 }}</span> 
                            to <span class="font-semibold">{{ $users->lastItem() ?? 0 }}</span> 
                            of <span class="font-semibold">{{ $users->total() }}</span> results
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @if ($users->onFirstPage())
                                <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <button wire:click="previousPage" class="px-3 py-2 bg-white text-blue-600 border-2 border-blue-200 rounded-lg hover:bg-yellow-400 hover:text-white hover:border-yellow-400 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                            @endif

                            @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                                <button wire:click="gotoPage({{ $page }})"
                                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 
                                    {{ $page === $users->currentPage() 
                                        ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md shadow-blue-200' 
                                        : 'bg-white text-blue-700 border-2 border-blue-200 hover:bg-yellow-400 hover:text-white hover:border-yellow-400' }}">
                                    {{ $page }}
                                </button>
                            @endforeach

                            @if ($users->hasMorePages())
                                <button wire:click="nextPage" class="px-3 py-2 bg-white text-blue-600 border-2 border-blue-200 rounded-lg hover:bg-yellow-400 hover:text-white hover:border-yellow-400 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            @else
                                <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>