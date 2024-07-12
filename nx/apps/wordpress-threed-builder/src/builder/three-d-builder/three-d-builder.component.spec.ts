import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ThreeDBuilderComponent } from './three-d-builder.component';

describe('ThreeDBuilderComponent', () => {
  let component: ThreeDBuilderComponent;
  let fixture: ComponentFixture<ThreeDBuilderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ThreeDBuilderComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(ThreeDBuilderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
